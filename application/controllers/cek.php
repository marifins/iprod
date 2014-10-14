<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Cek extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('cek_model');
        $this->load->model('produksi_model');
        $this->load->helper('url');
    }

    public function index($kebun = 0, $tanggal = 0)
    {
        $d['query'] = $this->cek_model->get_kebun_all();
        $d['rows'] = $this->cek_model->get_rows();
        $d['allkebun'] = $this->produksi_model->get_kebun_all();

        $this->load->library('parser');

        $data = array(
            'title' => 'Produksi',
            'judul' => 'Produksi',
            'content' => $this->load->view('cek/view_cek', $d, TRUE)
        );
        $this->parser->parse('template_cek', $data);
    }
    
    public function index_ajax($kebun = 0, $tanggal = 0)
    {
        $d['query'] = $this->cek_model->get_kebun_all($kebun, $tanggal);
        $d['rows'] = $this->cek_model->get_rows();
        $d['allkebun'] = $this->cek_model->get_kebun_all();

        $this->load->view('cek/view_cek', $d);
    }

}
?>