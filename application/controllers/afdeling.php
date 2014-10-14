<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Afdeling extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('afdeling_model');
        $this->load->model('luas_afdeling_model');
        $this->load->helper('url');
    }

    public function index($kebun = 0, $tahun = 0, $bulan = 0)
    {
        $this->load->library('parser');
        
        $d['query'] = $this->luas_afdeling_model->get_last_ten($kebun, $tahun);
        $d['rows'] = $this->luas_afdeling_model->get_rows($kebun, $tahun);
        $d['tahun'] = $this->luas_afdeling_model->get_tahun_all();

        $d['query_rko'] = $this->afdeling_model->get_last_ten($kebun = 0, $tahun = 0, $bulan = 0);
        $d['rows_rko'] = $this->afdeling_model->get_rows();
        
        $data = array(
            'title' => 'RKAP Afdeling',
            'judul' => 'RKAP Afdeling',
            'content' => $this->load->view('afdeling/view_afdeling', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function load_la($kebun = 0, $tahun = 0){
        $d['query'] = $this->luas_afdeling_model->get_last_ten($kebun, $tahun);
        $d['rows'] = $this->luas_afdeling_model->get_rows($kebun, $tahun);
        $d['tahun'] = $this->luas_afdeling_model->get_tahun_all();

        $this->load->view('afdeling/show_luas', $d);
    }

    public function load_af($kebun = 0, $tahun = 0, $bulan = 0){
        $d['tahun'] = $this->luas_afdeling_model->get_tahun_all();

        $d['query_rko'] = $this->afdeling_model->get_last_ten($kebun, $tahun, $bulan);
        $d['rows_rko'] = $this->afdeling_model->get_rows($kebun, $tahun, $bulan);

        $this->load->view('afdeling/show_afdeling', $d);
    }

    public function edit($register)
    {
        $this->load->library('parser');
        $d['status'] = $this->luas_afdeling_model->get_level();
        $d['rows_level'] = $this->luas_afdeling_model->get_rows();
        $d['row'] = $this->luas_afdeling_model->get_details($register);

        $data = array(
            'title' => 'Edit User',
            'judul' => 'EDIT USER',
        );

        $this->load->view('afdeling/edit_afdeling', $d);
    }

    public function insert() {
        $this->load->model('luas_afdeling_model');
        //$this->load->library('parser');
        $this->load->library('form_validation');
        $d['status'] = $this->luas_afdeling_model->get_level();
        $d['rows_level'] = $this->luas_afdeling_model->get_rows();
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run('user') == FALSE) {
            $data = array(
                'title' => 'Sistem Informasi Kebun',
                'judul' => 'Tambah Karyawan Pimpinan'
            );
            $this->load->view('afdeling/edit_afdeling', $d);
            //$this->parser->parse('template', $data);
        } else {
            $this->load->model('luas_afdeling_model');
            $this->luas_afdeling_model->insert_entry();
            $this->load->helper('url');
            redirect(base_url().'afdeling/index/');
        }
    }

    public function submit_la($tahun, $kebun) {
        if ($this->input->post('ajax')) {
            if ($this->input->post('edit')) {
                $this->luas_afdeling_model->update();
                $this->load_la($kebun, $tahun);
            } else {
                $this->luas_afdeling_model->save();
                $this->load_la($kebun, $tahun);
            }
        }
    }

    public function cek_data_la($tahun, $kebun, $afdeling){
        $cek = $this->luas_afdeling_model->cek_data_la($tahun, $kebun, $afdeling);
        echo $cek;
    }

    public function delete($kebun, $tahun) {
        $this->luas_afdeling_model->delete();
        $d = $this->load_la($kebun, $tahun);
    }

    public function submit_af($kebun = 0, $tahun = 0, $bulan = 0) {
        if ($this->input->post('ajax')) {
            if ($this->input->post('edit')) {
                $this->afdeling_model->update();
                $this->load_af($kebun, $tahun, $bulan);
            } else {
                $this->afdeling_model->save();
                $this->load_af($kebun, $tahun, $bulan);
            }
        }
    }

    public function cek_data_af($tahun, $bulan, $kebun, $afdeling){
        $cek = $this->afdeling_model->cek_data_af($tahun, $bulan, $kebun, $afdeling);
        echo $cek;
    }

    public function delete_af($kebun = 0, $tahun = 0, $bulan = 0) {
        $this->afdeling_model->delete();
        $this->load_af($kebun, $tahun, $bulan);
    }

    public function get_kebun_not_in($tahun){
        $d['kebun'] = $this->luas_afdeling_model->get_kebun_not_in($tahun);
        $this->load->view('afdeling/dropdown_kebun', $d);
    }

    function test($str){
        ?><script>alert("<?=$str;?>");</script><?php
    }
}
?>