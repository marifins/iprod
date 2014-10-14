<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Log extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('log_model');
        $this->load->helper('url');
        $this->load->library('auth');
        $this->auth->restrict();
	$this->auth->cek('log_entry');
    }

    public function index($page = 0)
    {
        $d['query'] = $this->log_model->get_last_ten(10,$page);
        $d['rows'] = $this->log_model->get_rows();

        $this->load->library('parser');
        $this->load->library('pagination');


        $count = $this->log_model->count();


        $config['base_url'] = 'http://127.0.0.1/iprod/log/index';
        $config['total_rows'] = $count;
     
        $this->pagination->initialize($config);

        $d['page_links'] = $this->pagination->create_links();

        $data = array(
            'title' => 'Log Entry',
            'judul' => 'LOG ENTRY',
            'content' => $this->load->view('log/view_log', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function details($id)
    {
        $this->load->library('parser');

        $d['row'] = $this->log_model->get_details($id);
        $data = array(
            'title' => 'Log Details',
            'judul' => 'LOG DETAILS',
        );
       
        $this->load->view('log/detail_log', $d);
    }

    public function add(){
        $this->load->library('parser');
        $d['status'] = $this->log_model->get_level();
        $d['rows_level'] = $this->log_model->get_rows();

        $data = array(
            'title' => 'Add Produksi',
            'judul' => 'ADD Produksi',
        );

        $this->load->view('log/edit_log', $d);
    }

    public function cek_data_log($kebun, $afdeling, $tanggal){
        $cek = $this->log_model->cek_data_log($kebun, $afdeling, $tanggal);
        echo $cek;
    }

    public function submit($tahun) {
        if ($this->input->post('ajax')) {
            if ($this->input->post('edit')) {
                $this->log_model->update();
            } else {
                $this->log_model->save();
            }
        }
    }

    public function delete($id) {
        $this->log_model->delete($id);
        $this->load->view('rkap/show_rkap', $d);
    }
    function test($str){
        ?><script>alert("<?=$str;?>");</script><?php
    }
}
?>