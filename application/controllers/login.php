<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package default_template
 * @modified Sep 2, 2010
 */

 class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('auth');
    }


    function do_login() {
        $this->auth->restrict(true);
        $this->load->library('auth');
        $login = array('username' => $this->input->post('username'),
            'password' => $this->input->post('password')
        );
        $return = $this->auth->do_login($login);
        if ($return) {
            echo "1";
        } else {
            echo "0";
        }
    }

    function do_logout(){
        $this->auth->logout();
        redirect(base_url()."");
    }
 }
 ?>