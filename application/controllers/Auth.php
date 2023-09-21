<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {


    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('AuthModel');

        $this->form_validation->set_error_delimiters('<small class="form-text text-danger">* ', '</small>');
        $this->form_validation->set_message('required', 'Kolom {field} harus diisi');
        $this->form_validation->set_message('numeric', 'Isi kolom {field} dengan angka (0-9)');
        $this->form_validation->set_message('min_length', 'Kolom {field} minimal {param} digit');
        $this->form_validation->set_message('max_length', 'Kolom {field} maksimal {param} digit');
        $this->form_validation->set_message('is_unique', '%s ini sudah ada');
        $this->form_validation->set_message('matches', 'Kolom {field} harus sama dengan kolom {param}');

    }


    private function template($page, $data = null) {

        $this->load->view($page, $data);

    }


	public function index() {

        
        if($this->session->userdata('email')){
            redirect('dashboard');
        }
        
        $data['title'] = 'Login Page';

        $this->form_validation->set_rules('email', 'email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        
        if ($this->form_validation->run() == false) {
            $this->template('auth/login', $data);
        } else {
            $this->_login();
        }

	}


	public function login() {

        
        if($this->session->userdata('email')){
            redirect('dashboard');
        }

        $data['title'] = 'Login Page';

        $this->form_validation->set_rules('email', 'email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        
        if ($this->form_validation->run() == false) {
            $this->template('auth/login', $data);
        } else {
            $this->_login();
        }

	}
    

    private function _login(){

        $email      = $this->input->post('email');
        $password   = $this->input->post('password');

        $user       = $this->db->get_where('users_account', ['email' => $email])->row_array();
        
        // Jika usernya ada.
        if ($user) {
            // JIka user nya aktif.
            if ($user['is_active'] == 1) {
                # Cek Password
                if (password_verify($password, $user['password'])) {

                    $session   = array(
                        'user_id'       => $user['id'],
                        'email'         => $user['email'],
                        'role_id'       => $user['role_id'],
                        'status_login'  => 'online'
                    );

                    $this->AuthModel->updateStatusOnline($session['user_id']);
                    
                    $this->session->set_userdata($session);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-white" role="alert"><strong>Password</strong> anda salah!</span></div>');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-warning text-white" role="alert"><strong>Akun</strong> anda belum aktif. Silahkan hubungi admin!</span></div>');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning text-white" role="alert"><strong>Akun</strong> anda belum terdaftar. Silahkan daftarkan akun!</span></div>');
            redirect('auth/login');
        }

    }


	public function signup() {


        if($this->session->userdata('email')){
            redirect('welcome');
        }

        $data['title'] = 'Daftar';

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users_account.email]',[
            'is_unique' => 'email sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]', [
            'matches' => 'Password tidak sama!',
            'min_length' => 'Password terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');
        
        if ($this->form_validation->run() == false){
            $this->load->view('auth/signup', $data);
        } else {
            $date       = date('ymd');
            $time       = date('His');
            $id         = "ID".$date."-".rand(100,999);
            $nama       = $this->input->post('nama', true);
            $email      = $this->input->post('email', true);
            $password   = $this->input->post('password1');
            $data       = [
                'id'            => $id,
                'nama'          => htmlspecialchars($nama),
                'email'         => htmlspecialchars($email),
                'password'      => password_hash($password, PASSWORD_DEFAULT),
                'image'         => 'user.png',
                'role_id'       => 3,
                'is_active'     => 0,
                'date_created'  => time()
            ];

            $token  = base64_encode(random_bytes(32));
            $user_token = [
                'id_user'       => $id,
                'email'         => $email,
                'token'         => $token,
                'date_created'  => time()
            ];

            $this->db->insert('user_token', $user_token);

            $this->db->insert('users_account', $data);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success text-white" role="alert"><strong>Selamat!</strong> Akun anda berhasil dibuat. Silahkan aktivasi akun!</span></div>');
            redirect('auth/login');
        }

	}


    private function _sendEmail($token, $type){

        $config = [
            'protocol'      => 'smtp',
            'smtp_host'     => 'ssl://smtp.googlemail.com',
            // 'smtp_user'  => 'aku@dyzulk.com',
            // 'smtp_pass'  => '@Synthesis1996',
            'smtp_user'     => 'dyzulk04@gmail.com',
            'smtp_pass'     => 'qhfiugstswaehokp',
            'smtp_port'     => 465,
            'smtp_timeout'  => '7',
            'mailtype'      => 'html',
            'charset'       => 'utf-8',
            'newline'       => "\r\n",
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('dyzulksolution@dyzulk.com', 'CI App');
        
        if ($type == 'verify'){

            $email          = $this->input->post('email');
            $token_ok       = urlencode($token);
            $data['link']   = base_url().'auth/verify?email='.$email.'&token='.$token_ok;
            $this->email    -> to($this->input->post('email'));
            $this->email    -> subject('Account Verification Dyzulk DeveloperX');
            $this->email    -> message($this->load->view('email/activation', $data, true));

        } else if ($type == 'forgot') {

            $email          = $this->session->userdata('reset_password');
            $token_ok       = urlencode($token);
            $data['link']   = base_url().'auth/resetpassword?email='.$email.'&token='.$token_ok;
            $data['email']  = $email;
            $this->email    -> to($email);
            $this->email    -> subject('Reset Password Dyzulk DeveloperX');
            $this->email    -> message($this->load->view('email/password', $data, true));
            
        }
        
        if($this->email->send()){
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }

    }


    public function verify(){

        $data['title']      = 'Verify Account';

        $email              = $this->input->get('email');
        $token              = $this->input->get('token');

        $user               = $this->db->get_where('users_account', ['email' => $email])->row_array();

        if($user){

            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if($user_token){
                
                if(time() - $user_token['date_created'] < (60*60*24)){
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('users_account');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-white" role="alert"><strong>'.$email.'</strong> berhasil diaktifkan! Silahkan login!</span></div>');
                    redirect('auth/login');
                } else {
                    $this->db->delete('users_account', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-white" role="alert">Account activation failed! Token expired!</span></div>');
                    redirect('auth/login');
                }

            } else {

                $this->session->set_flashdata('message', '<div class="alert alert-danger text-white" role="alert">Account activation failed! Wrong Token!</span></div>');
                redirect('auth/login');

            }

        } else {

            $this->session->set_flashdata('message', '<div class="alert alert-danger text-white" role="alert">Account activation failed! Wrong Email!</span></div>');
            redirect('auth/login');

        }

    }


    public function logout(){

        $data['title']      = 'Logout';

        $this->AuthModel->updateStatusOffline($this->session->userdata('user_id'));

        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success text-white" role="alert"><strong>Anda</strong> berhasil logout!</span></div>');

        redirect('auth/login');
        
    }


    public function blocked(){

        // $this->load->view('utility/blocked');
        $this->load->view('utility/access_denied');

    }


    public function forgotPassword(){

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $data['title'] = 'Forgot Password';
        
        if ($this->form_validation->run() == false) {
            $this->template('auth/forgotpassword', $data);
            
        } else {

            $email      = $this->input->post('email');
            $user       = $this->db->get_where('users_account', ['email' => $this->input->post('email'), 'is_active' => 1])->row_array();
            
            if($user){
                
                $id         = $user['id'];
                $email      = $user['email'];
                $token      = base64_encode(random_bytes(32));
                $this->session->set_userdata('reset_password', $email);
                
                $user_token = [
                    'id_user'       => $id,
                    'email'         => $email,
                    'token'         => $token,
                    'date_created'  => time()
                ];

    
                $this->db->insert('user_token', $user_token);
                
                $this->_sendEmail($token, 'forgot', $email);

    
                $this->session->set_flashdata('message', '<div class="alert alert-success text-white" role="alert"><strong>Silahkan</strong> cek email anda untuk reset password!</span></div>');
                redirect('auth/forgotpassword');

            } else {

                $this->set_flashdata('message', '<div class="alert alert-danger text-white" role="alert">Email is not registered or activated!</span></div>');
                redirect('auth/forgotpassword');

            }
        }

    }


    public function resetPassword(){

        $email      = $this->input->get('email');
        $token      = $this->input->get('token');

        $user   = $this->db->get_where('users_account', ['email' => $email])->row_array();

        if($user) {

            $user_token     = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if($user_token) {
                
                $this->session->set_userdata('reset_password', $email);
                $this->changePassword();
            
            } else {
                
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-white" role="alert">Reset password failed! Wrong Token!</span></div>');
                redirect('auth/login');
    
            }

        } else {
            
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-white" role="alert">Reset password failed! Wrong Email!</span></div>');
            redirect('auth/login');
        }
    }


    public function changePassword(){

        if(!$this->session->userdata('reset_password')){
            redirect('auth/login');
        }

        $data['title']          = 'Change Password';

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');

        if($this->form_validation->run() == false){
            $this->template('auth/change-password', $data);

        } else {
            $password   = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email   = $this->session->userdata('reset_password');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('users_account');

            $this->session->unset_userdata('reset_password');

            $this->session->set_flashdata('message', '<div class="alert alert-success text-white" role="alert"><strong>Password</strong> berhasil diubah! Silahkan login!</span></div>');
            redirect('auth/login');
        }
        
        
    }

    
}
