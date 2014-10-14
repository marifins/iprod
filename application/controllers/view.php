<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class View extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('view_model');
        $this->load->model('produksi_model');
        $this->load->helper('url');
        $this->load->library('auth');
        $this->auth->restrict();
	$this->auth->cek('view');
    }

    public function index($kebun = 0, $tanggal = 0)
    {
        $d['query'] = $this->view_model->get_data($kebun, $tanggal);
        $d['rows'] = $this->view_model->get_rows();
        $d['allkebun'] = $this->produksi_model->get_kebun_all();
        $d['kebun'] = $kebun;

        $this->load->library('parser');

        $data = array(
            'title' => 'Produksi',
            'judul' => 'Produksi',
            'content' => $this->load->view('view/view', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }
    
    public function index_ajax($kebun = 0, $tanggal = 0)
    {
        $d['query'] = $this->view_model->get_data($kebun, $tanggal);
        $d['rows'] = $this->view_model->get_rows();
        $d['allkebun'] = $this->produksi_model->get_kebun_all();
        $d['kebun'] = $kebun;

        $this->load->view('view/show', $d);
    }

}
?>