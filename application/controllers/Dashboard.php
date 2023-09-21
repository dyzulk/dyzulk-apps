<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        
        // Memeriksa status login pengguna
        if (!$this->session->userdata('email')) {
            // Jika pengguna belum login, alihkan ke halaman login atau tindakan lainnya
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-white" role="alert">Silahkan login terlebih dahulu !</div>');
			redirect('auth');
        }
    }


	public function index()

	{

        $this->load->model('UserModel');

        $data['total_users']        = $this->UserModel->getTotalUsers();
        $data['total_amount']       = $this->UserModel->getTotalAmount();
        $data['total_online_users'] = $this->UserModel->getTotalOnlineUsers();
        $data['users']              = $this->UserModel->getUsers();
        
		$data['title']              = 'Dashboard';
		$data['user']               = $this->db->get_where('users_account', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('partials/01header', $data);
		$this->load->view('Dashboard', $data);
	}


}
