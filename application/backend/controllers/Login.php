<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        if ($user = $this->session->userdata('user')) {
            redirect('/index', 'location');
        } else {
            $this->load->view('login',$this->data);
        }
    }
    
    public function verify()
    {
        if (! $captcha = $this->input->post('captcha')) {
            $this->output->display(array('status'=>3));
        }
        $this->load->library('captcha');
        if (! $this->captcha->check(strtolower($captcha))){
            $this->output->display(array('status'=>2));
        }

        $this->load->model('Admin_model', 'admin');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($user = $this->admin->verify($username,$password)) {
            $this->admin->update($user->id, array(
                'last_login_ip' => $this->input->ip_address()
            ));
            $this->session->set_userdata('user', array(
                'userid' => $user->id,
                'username' => $user->username,
                'groups' => $user->groups_id
            ));
            $this->output->display(array('status'=>0));
        } else {
            $this->output->display(array('status'=>1));
        }
    }

    public function captcha() {
        $this->load->library('captcha', array(
            'width' => 95,
            'height' => 25,
            'fontsize' => 12
        ));
        $this->captcha->create();
    }

    public function out()
    {
        $this->session->sess_destroy();
        redirect('login', 'location');
    }
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */