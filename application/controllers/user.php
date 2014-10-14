<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class User extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('auth');
        $this->auth->restrict();
	$this->auth->cek('manajemen_user');
    }

    public function index($page = 0)
    {
        $this->load->library('parser');
        $d = $this->getpagelink($page);
        $data = array(
            'title' => 'User Management',
            'judul' => 'USER MANAGEMENT',
            'content' => $this->load->view('user/view_user', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function getpagelink($page = 0){
        $d['query'] = $this->user_model->get_last_ten(10,$page);
        $d['rows'] = $this->user_model->get_rows();
        $d['status'] = $this->user_model->get_level();
        $d['rows_level'] = $this->user_model->get_rows();

        
        $this->load->library('pagination');


        $count = $this->user_model->count();


        $config['base_url'] = 'http://127.0.0.1/iprod/user/index';
        $config['total_rows'] = $count;

        $this->pagination->initialize($config);

        $d['page_links'] = $this->pagination->create_links();
        return $d;
    }

    public function details($register)
    {
        $this->load->library('parser');

        $d['row'] = $this->user_model->get_details($register);
        $data = array(
            'title' => 'User Details',
            'judul' => 'USER DETAILS',
        );
       
        $this->load->view('user/detail_user', $d);
    }

    public function register()
    {
        $this->load->library('parser');
        $d['status'] = $this->user_model->get_level();
        $d['rows_level'] = $this->user_model->get_rows();

        $data = array(
            'title' => 'New User',
            'judul' => 'NEW USER',
        );
       
        $this->load->view('user/edit_user', $d);
    }

    public function edit($register)
    {
        $this->load->library('parser');
        $d['status'] = $this->user_model->get_level();
        $d['rows_level'] = $this->user_model->get_rows();
        $d['row'] = $this->user_model->get_details($register);

        $data = array(
            'title' => 'Edit User',
            'judul' => 'EDIT USER',
        );

        $this->load->view('user/edit_user', $d);
    }
    
    public function insert() {
        $this->load->model('user_model');
        //$this->load->library('parser');
        $this->load->library('form_validation');
        $d['status'] = $this->user_model->get_level();
        $d['rows_level'] = $this->user_model->get_rows();
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run('user') == FALSE) {
            $data = array(
                'title' => 'Sistem Informasi Kebun',
                'judul' => 'Tambah Karyawan Pimpinan'
            );
            $this->load->view('user/edit_user', $d);
            //$this->parser->parse('template', $data);
        } else {
            $this->load->model('user_model');
            $this->user_model->insert_entry();
            $this->load->helper('url');
            redirect(base_url().'user/index/');
        }
    }

    public function edit_b($register)
    {
        $this->load->library('parser');
        $d['status'] = $this->user_model->get_level();
        $d['rows_level'] = $this->user_model->get_rows();
        $d['row'] = $this->user_model->get_details($register);

        $data = array(
            'title' => 'Edit User',
            'judul' => 'EDIT USER',
        );

        $this->load->view('user/edit_user', $d);
    }
    public function submit() {
        if ($this->input->post('ajax')) {
            if ($this->input->post('edit')) {
                $this->user_model->update();
                $d = $this->getpagelink(0);
                $this->load->view('user/show_user', $d);
            } else {
                $this->user_model->save();
                $d = $this->getpagelink(0);
                $this->load->view('user/show_user', $d);
            }
        }
    }

    public function delete() {
        $this->user_model->delete();
        $d = $this->getpagelink(0);
        $this->load->view('user/show_user', $d);
    }
}
?>