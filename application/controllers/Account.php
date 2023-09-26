<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');

        // Memeriksa status login pengguna
        if (!$this->session->userdata('email')) {
            // Jika pengguna belum login, alihkan ke halaman login atau tindakan lainnya
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-white" role="alert">Silahkan login terlebih dahulu !</div>');
            redirect('auth');
        }
    }


	public function index()

	{
		$data['title']		= 'My Account';
		$data['user']		= $this->db->get_where('users_account', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('partials/01header-for-account', $data);
		$this->load->view('account', $data);
	}


    public function security()

    {
        $data['title']		= 'Security';
        $data['user']		= $this->db->get_where('users_account', ['email' => $this->session->userdata('email')])->row_array();
        // $data['passJs']		= '<script src="'.base_url().'src/js/password.js"></script>';

        $this->load->view('partials/01header', $data);
        $this->load->view('security', $data);
    }


    public function updatePassword()

    {
        $password   = $this->input->post('password');
        $password1  = $this->input->post('password1');
        $password2  = $this->input->post('password2');
        
        $this->form_validation->set_rules('password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('password1', 'New Password', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('password2', 'Confirm New Password', 'required|trim|min_length[3]|matches[password1]');

        $data       = password_hash($password1, PASSWORD_DEFAULT);

        $this->db->where('email', $this->session->userdata('email'));
        $this->db->update('users_account', ['password' => $data]);
        
        $this->session->set_flashdata('message', '<div class="alert alert-success text-white" role="alert">Password has been changed !</div>');
        redirect('account/security');
    }


}
