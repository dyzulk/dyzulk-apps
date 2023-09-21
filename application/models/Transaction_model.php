<?php
class Transaction_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Fungsi untuk mengambil data transaksi dengan join ke tabel users_account
    public function getTransactions() {
        $this->db->select('user_transaction.*, users_account.nama, users_account.email, users_account.image');
        $this->db->from('user_transaction');
        $this->db->join('users_account', 'user_transaction.user_email = users_account.email', 'left');
        $this->db->order_by('user_transaction.time_transaction', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getTransactionById($id) {
        $this->db->select('user_transaction.*, users_account.nama, users_account.email, users_account.image');
        $this->db->from('user_transaction');
        $this->db->join('users_account', 'user_transaction.user_email = users_account.email', 'left');
        $this->db->where('user_transaction.id', $id);
        return $this->db->get()->row_array();
    }
}
