<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Go extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('go_model');
        $this->load->model('produksi_model');
        $this->load->helper('url');
        $this->load->library('auth');
        $this->auth->restrict();
	$this->auth->cek('view');
    }

    public function index($kebun = 0, $tanggal = 0)
    {
        $d['query'] = $this->go_model->get_data($kebun, $tanggal);
        $d['rows'] = $this->go_model->get_rows();
        $d['allkebun'] = $this->produksi_model->get_kebun_all();
        if($tanggal == 0) $tanggal = date('Y-m-d');
        $d['tanggal'] = $tanggal;


        $this->load->library('parser');

        $data = array(
            'title' => 'Produksi',
            'judul' => 'Produksi',
            'content' => $this->load->view('print/view', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }
    
    public function index_ajax($kebun = 0, $tanggal = 0)
    {
        $d['query'] = $this->go_model->get_data($kebun, $tanggal);
        $d['rows'] = $this->go_model->get_rows();
        $d['allkebun'] = $this->produksi_model->get_kebun_all();
        if($tanggal == 0) $tanggal = date('Y-m-d');
        $d['tanggal'] = $tanggal;

        $this->load->view('print/show', $d);
    }

}
?>