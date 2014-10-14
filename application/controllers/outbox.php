<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Outbox extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('outbox_model');
        $this->load->helper('url');
        $this->load->library('auth');
        $this->auth->restrict();
	$this->auth->cek('outbox');
    }

    public function index($page = 0)
    {
        $d['query'] = $this->outbox_model->get_last_ten(10,$page);
        $d['rows'] = $this->outbox_model->get_rows();

        $this->load->library('parser');
        $this->load->library('pagination');


        $count = $this->outbox_model->count();

        $base = base_url();
        $config['base_url'] = $base.'inbox/index';
        $config['total_rows'] = $count;
     
        $this->pagination->initialize($config);

        $d['page_links'] = $this->pagination->create_links();

        $data = array(
            'title' => 'Outbox SMS Server',
            'judul' => 'OUTBOX SMS',
            'content' => $this->load->view('outbox/view_outbox', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }
    
    public function send($page = 0){
        if ($this->input->post('ajax')) {
            if ($this->input->post('edit')) {
                $this->outbox_model->update();
            } else {
                $this->outbox_model->save();
            }
        }
        
        $d['query'] = $this->outbox_model->get_last_ten(10,$page);
        $d['rows'] = $this->outbox_model->get_rows();
        $this->load->view('outbox/show_outbox', $d);
    }
}
?>