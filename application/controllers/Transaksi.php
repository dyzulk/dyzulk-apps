<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {


	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('Transaction_model');
        
        // Memeriksa status login pengguna
        if (!$this->session->userdata('email')) {
            // Jika pengguna belum login, alihkan ke halaman login atau tindakan lainnya
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-white" role="alert">Silahkan login terlebih dahulu !</div>');
			redirect('auth');
        }
    }
	

	private function template($page, $data = null) {

		$this->load->view('partials/01header', $data);
		$this->load->view($page, $data);

    }


	public function index()

	{
		$data['title']		= 'Transaksi';
		$data['user']		= $this->db->get_where('users_account', ['email' => $this->session->userdata('email')])->row_array();
		$data['total']		= $this->totalTransaction();
		
		$this->template('transaction/view', $data);
	}


    public function admin()

	{
		$data['title']		= 'Transaction for Admin';
		$data['user']		= $this->db->get_where('users_account', ['email' => $this->session->userdata('email')])->row_array();
		$data['users']		= $this->db->get('users_account')->result_array();
		$data['transData']	= $this->Transaction_model->getTransactions();
		
		$this->template('transaction/admin', $data);
	}


	public function addData(){

		$this->_addData();

	}

	
	private function _addData(){

		$id_user		= $this->input->post('id');

		$db				= $this->db->get_where('users_account', ['id' => $id_user])->row_array();

		$id				= 'IT-'.date('ymd').rand(100, 999); // 'IT-20210914_1234
		$nama			= $db['nama'];
		$email			= $db['email'];
		$amount			= $this->input->post('amount');
		$time			= time();

		$data = [

			'id'				=> $id,
			'categori_id'		=> 'K-000001',
			'user_id'			=> $id_user,
			'user_email'		=> $email,
			'amount'			=> $amount,
			'time_transaction'	=> $time

		];

		$this->db->insert('user_transaction', $data);

		$this->session->set_flashdata('message', '<div class="alert alert-success text-white" role="alert">Data berhasil ditambahkan !</div>');
		redirect('transaksi/admin');

		print_r($data);

	}


	public function editData(){

		$data['title']		= 'Edit User';
		$data['user']		= $this->db->get_where('users_account', ['email' => $this->session->userdata('email')])->row_array();

		$id 				= $this->input->get('id');
		$data['userEdit']	= $this->db->query("SELECT * FROM user_transaction WHERE id='$id'")->result();
		$data['transData']	= $this->Transaction_model->getTransactionById($id);
		$this->template('transaction/edit', $data);

	}

	
	public function updateData(){
		
		$id			= $this->input->post('id');
		$amount		= $this->input->post('amount');
		$time		= time();

		$data		= array(

			'amount'	=> $amount,
			'other'		=> $time

		);

		$this->db->where('id', $id);
		$this->db->set($data);
		$this->db->update('user_transaction');

		$this->session->set_flashdata('message', '<div class="alert alert-success text-white" role="alert">Data berhasil diubah !</div>');
		redirect('transaksi/admin');
	}


	public function deleteData(){

		$id		= $this->input->get('id');
		$where	= array('id' => $id);
		$this->db->delete('user_transaction', $where);
		
		$this->session->set_flashdata('message', '<div class="alert alert-success text-white" role="alert">Data berhasil dihapus !</div>');
		redirect('transaksi/admin');

	}

	
	private function transData(){

		$data   = $this->db->get('user_transaction')->result_array();
		return $data;

	}


	private function totalTransaction(){

        $data   = $this->db->get('user_total_transaction')->result_array();
		return $data;

    }

}
