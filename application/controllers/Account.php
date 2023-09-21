<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {


	public function index()

	{
		$data['title']		= 'My Account';
		$data['user']		= $this->db->get_where('users_account', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('partials/01header', $data);
		$this->load->view('account', $data);
	}


    public function security()

    {
        $data['title']		= 'Security';
        $data['user']		= $this->db->get_where('users_account', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('partials/01header', $data);
        $this->load->view('security', $data);
    }


}
