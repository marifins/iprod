<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Rkap extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('rkap_model');
        $this->load->model('rko_model');
        $this->load->helper('url');
    }

    public function index($tahun = 0, $bulan = 0)
    {
        $this->load->library('parser');
        
        $d['query'] = $this->rkap_model->get_last_ten($tahun);
        $d['rows'] = $this->rkap_model->get_rows();
        $d['tahun'] = $this->rkap_model->get_tahun_all();

        $d['query_rko'] = $this->rko_model->get_last_ten($tahun, $bulan);
        $d['rows_rko'] = $this->rko_model->get_rows();
        
        $data = array(
            'title' => 'RKAP Kebun',
            'judul' => 'RKAP Kebun',
            'content' => $this->load->view('rkap/view_rkap', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function load_rkap($tahun = 0){
        $d['query'] = $this->rkap_model->get_last_ten($tahun);
        $d['rows'] = $this->rkap_model->get_rows($tahun);
        $d['tahun'] = $this->rkap_model->get_tahun_all();

        $this->load->view('rkap/show_rkap', $d);
    }

    public function load_rko($tahun = 0, $bulan = 0){
        $d['tahun'] = $this->rko_model->get_tahun_all();

        $d['query_rko'] = $this->rko_model->get_last_ten($tahun, $bulan);
        $d['rows_rko'] = $this->rko_model->get_rows($tahun, $bulan);

        $this->load->view('rkap/show_rko', $d);
    }

    public function get_data($tahun = 0, $bulan = 0){
        $d['query'] = $this->rkap_model->get_last_ten($tahun);
        $d['rows'] = $this->rkap_model->get_rows();
        $d['tahun'] = $this->rkap_model->get_tahun_all();

        $d['query_rko'] = $this->rko_model->get_last_ten($tahun, $bulan);
        $d['rows_rko'] = $this->rko_model->get_rows();
        return $d;
    }

    public function details($register)
    {
        $this->load->library('parser');

        $d['row'] = $this->rkap_model->get_details($register);
        $data = array(
            'title' => 'User Details',
            'judul' => 'USER DETAILS',
        );

        $this->load->view('user/detail_user', $d);
    }

    public function register()
    {
        $this->load->library('parser');
        $d['status'] = $this->rkap_model->get_level();
        $d['rows_level'] = $this->rkap_model->get_rows();

        $data = array(
            'title' => 'New User',
            'judul' => 'NEW USER',
        );

        $this->load->view('user/edit_user', $d);
    }

    public function edit($register)
    {
        $this->load->library('parser');
        $d['status'] = $this->rkap_model->get_level();
        $d['rows_level'] = $this->rkap_model->get_rows();
        $d['row'] = $this->rkap_model->get_details($register);

        $data = array(
            'title' => 'Edit User',
            'judul' => 'EDIT USER',
        );

        $this->load->view('user/edit_user', $d);
    }

    public function insert() {
        $this->load->model('rkap_model');
        //$this->load->library('parser');
        $this->load->library('form_validation');
        $d['status'] = $this->rkap_model->get_level();
        $d['rows_level'] = $this->rkap_model->get_rows();
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run('user') == FALSE) {
            $data = array(
                'title' => 'Sistem Informasi Kebun',
                'judul' => 'Tambah Karyawan Pimpinan'
            );
            $this->load->view('user/edit_user', $d);
            //$this->parser->parse('template', $data);
        } else {
            $this->load->model('rkap_model');
            $this->rkap_model->insert_entry();
            $this->load->helper('url');
            redirect(base_url().'user/index/');
        }
    }

    public function edit_b($register)
    {
        $this->load->library('parser');
        $d['status'] = $this->rkap_model->get_level();
        $d['rows_level'] = $this->rkap_model->get_rows();
        $d['row'] = $this->rkap_model->get_details($register);

        $data = array(
            'title' => 'Edit User',
            'judul' => 'EDIT USER',
        );

        $this->load->view('user/edit_user', $d);
    }
    public function submit($tahun) {
        if ($this->input->post('ajax')) {
            if ($this->input->post('edit')) {
                $this->rkap_model->update($tahun);
                $d = $this->get_data($tahun);
                $this->load->view('rkap/show_rkap', $d);
            } else {
                $this->rkap_model->save();
                $d = $this->get_data($tahun);
                $this->load->view('rkap/show_rkap', $d);
            }
        }
    }

    public function cek_data_rkap($tahun, $kebun){
        $cek = $this->rkap_model->cek_data_rkap($tahun, $kebun);
        echo $cek;
    }

    public function delete($tahun) {
        $this->rkap_model->delete();
        $d = $this->get_data($tahun);
        $this->load->view('rkap/show_rkap', $d);
    }

    public function submit_rko($tahun, $bulan) {
        if ($this->input->post('ajax')) {
            if ($this->input->post('edit')) {
                $this->rko_model->update();
                $d = $this->get_data($tahun, $bulan);
                $this->load->view('rkap/show_rko', $d);
            } else {
                $this->rko_model->save();
                $d = $this->get_data($tahun, $bulan);
                $this->load->view('rkap/show_rko', $d);
            }
        }
    }

    public function cek_data_rko($tahun, $bulan, $kebun){
        $cek = $this->rko_model->cek_data_rko($tahun, $bulan, $kebun);
        echo $cek;
    }

    public function delete_rko($tahun, $bulan) {
        $this->rko_model->delete();
        $d = $this->get_data($tahun, $bulan);
        $this->load->view('rkap/show_rko', $d);
    }

    public function get_kebun_not_in($tahun){
        $d['kebun'] = $this->rkap_model->get_kebun_not_in($tahun);
        $this->load->view('rkap/dropdown_kebun', $d);
    }

    function test($str){
        ?><script>alert("<?=$str;?>");</script><?php
    }
}
?>