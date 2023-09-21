<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {


    public function __construct()
    {
        
        parent::__construct();
        $this->load->model('Transaction_model');

    }


	public function index()

	{
        echo "========================  array get_data()  ========================"."<br><br>";
        $this->get_data();
        echo "<br><br>"."========================  terjemah time()  ========================"."<br><br>";
        $this->time();
        echo "<br><br>"."========================  totalTransaction()  ========================"."<br><br>";
        $this->totalTransaction();
        echo "<br><br>"."========================  transaction()  ========================"."<br><br>";
        $this->transaction();
        echo "<br><br>"."========================  session  ========================"."<br><br>";
        print_r($this->session->userdata());
	}


    private function get_data(){

        $query = $this->db->get('users_account'); // Ambil data dari tabel 'users_account'

        if ($query->num_rows() > 0) {
            $result = $query->result_array(); // Konversi hasil kueri menjadi array
            // Sekarang $result berisi data dari tabel users_account dalam bentuk array
            echo "<pre>"; // Tampilkan dengan format preformatted agar lebih rapih  
            print_r($result); // Menampilkan data sebagai array
            echo "</pre>";
        } else {
            echo "Tidak ada data ditemukan.";
        }

    }


    private function time(){

        $timestamp          = 1694737797;
        $waktu_kalendar     = date("Y-m-d H:i:s", $timestamp);
        $tgl_lahir          = date("Y-m-d");
        $time               = time();

        echo "Timestamp\t:" . $timestamp ."\t\t=\t" . "Converted\t:".$waktu_kalendar;
        echo "<br>";
        echo "Tgl_Lahir\t:".$tgl_lahir;
        echo "<br>";
        echo "time()\t:".$time;

    }


    private function totalTransaction(){

        $data   = $this->db->get('user_total_transaction')->result_array();
        echo "<pre>";
        print_r($data);
        echo "</pre>";

    }


    private function transaction(){

        $data   = $this->Transaction_model->getTransactions();
        echo "<pre>";
        print_r($data);
        echo "</pre>";

    }


    public function aktivasi(){

        $email              = 'dyzulkdeveloper@gmail.com';
        $token              = base64_encode(random_bytes(32));
        $data['title']		= 'Aktivasi';
        $data['link']		= base_url().'auth/verify?email='.$email.'&token='.urlencode($token);

        $this->load->view('email/activation', $data);

    }


    public function password(){

        $email              = 'dyzulkdeveloper@gmail.com';
        $token              = base64_encode(random_bytes(32));
        $data['title']		= 'Password';
        $data['email']		= $email;
        $data['link']		= base_url().'auth/resetpassword?email='.$email.'&token='.$token;

        $this->load->view('email/password', $data);

    }

}
