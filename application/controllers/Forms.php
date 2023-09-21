<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {


	public function index()

	{
		$data['title']		= 'Forms';
		$data['user']		= $this->db->get_where('users_account', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('partials/01header', $data);
		$this->load->view('forms', $data);
	}


}
