<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Member extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('member_model');
        $this->load->helper('url');
        $this->load->library('auth');
        $this->auth->restrict();
	$this->auth->cek('manajemen_member');
    }

    public function index($page = 0)
    {
        $this->load->library('parser');
        $d = $this->getpagelink($page);
        $data = array(
            'title' => 'Member Management',
            'judul' => 'MEMBER MANAGEMENT',
            'content' => $this->load->view('member/view_member', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function getpagelink($page = 0){
        $d['query'] = $this->member_model->get_last_ten(10,$page);
        $d['rows'] = $this->member_model->get_rows();
        $d['kebun'] = $this->member_model->get_kebun_all();
        
        $this->load->library('pagination');


        $count = $this->member_model->count();


        $config['base_url'] = 'http://127.0.0.1/iprod/member/index';
        $config['total_rows'] = $count;

        $this->pagination->initialize($config);

        $d['page_links'] = $this->pagination->create_links();
        return $d;
    }

    public function details($register)
    {
        //$this->load->library('parser');

        $d['row'] = $this->member_model->get_details($register);

        $this->load->view('member/detail_member', $d);
    }

    public function register()
    {
        $this->load->library('parser');
        $d['status'] = $this->member_model->get_level();
        $d['rows_level'] = $this->member_model->get_rows();

        $data = array(
            'title' => 'New User',
            'judul' => 'NEW USER',
        );
       
        $this->load->view('user/edit_user', $d);
    }

    public function edit($register)
    {
        $this->load->library('parser');
        $d['status'] = $this->member_model->get_level();
        $d['rows_level'] = $this->member_model->get_rows();
        $d['row'] = $this->member_model->get_details($register);

        $data = array(
            'title' => 'Edit User',
            'judul' => 'EDIT USER',
        );

        $this->load->view('user/edit_user', $d);
    }
    
    public function insert() {
        $this->load->model('member_model');
        //$this->load->library('parser');
        $this->load->library('form_validation');
        $d['status'] = $this->member_model->get_level();
        $d['rows_level'] = $this->member_model->get_rows();
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run('user') == FALSE) {
            $data = array(
                'title' => 'Sistem Informasi Kebun',
                'judul' => 'Tambah Karyawan Pimpinan'
            );
            $this->load->view('user/edit_user', $d);
            //$this->parser->parse('template', $data);
        } else {
            $this->load->model('member_model');
            $this->member_model->insert_entry();
            $this->load->helper('url');
            redirect(base_url().'user/index/');
        }
    }

    public function edit_b($register)
    {
        $this->load->library('parser');
        $d['status'] = $this->member_model->get_level();
        $d['rows_level'] = $this->member_model->get_rows();
        $d['row'] = $this->member_model->get_details($register);

        $data = array(
            'title' => 'Edit User',
            'judul' => 'EDIT USER',
        );

        $this->load->view('user/edit_user', $d);
    }
    public function submit() {
        if ($this->input->post('ajax')) {
            if ($this->input->post('edit')) {
                $this->member_model->update();
            } else {
                $this->member_model->save();
            }
        }
    }

    public function delete($reg) {
        $this->member_model->delete($reg);
    }

    public function cek_data_member($reg){
        $cek = $this->member_model->cek_data_member($reg);
        echo $cek;
    }
}
?>