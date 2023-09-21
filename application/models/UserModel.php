<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

    public function getUsers(){
        $query = $this->db->get('users_account');
        return $query->result_array();
    }
    
    public function getTotalUsers() {
        $query = $this->db->query("SELECT COUNT(*) AS total_users FROM users_account");
        return $query->row()->total_users;
    }

    public function getTotalAmount() {
        $query = $this->db->query("SELECT SUM(amount) AS total_amount FROM user_transaction");
        return $query->row()->total_amount;
    }

    public function getTotalOnlineUsers() {
        $this->db->select('COUNT(*) as total_online_users');
        $this->db->where('status_login', 'online');
        $query = $this->db->get('users_account');
        return $query->row()->total_online_users;
    }
    
}
