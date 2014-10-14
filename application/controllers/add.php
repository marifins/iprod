<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Add extends CI_Controller{

    public function __construct() {
        parent::__construct();
		$this->load->model('harian_model');
    }
    
    public function index(){
		$this->load->library('parser');
		$data = array(
            'title' => 'Data Produksi Harian',
            'judul' => 'Data Produksi Harian',
            'content' => $this->load->view('add', '', TRUE)
        );
        $this->parser->parse('template', $data);
    }
	
	public function go(){
        $this->harian_model->save();
        $this->load->helper('url');
        redirect(base_url().'harian/');
	}

}
?>