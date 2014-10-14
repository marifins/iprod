<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Sent_items extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('sentitems_model');
        $this->load->helper('url');
    }

    public function index($page = 0)
    {
        $d['query'] = $this->sentitems_model->get_last_ten(10,$page);
        $d['rows'] = $this->sentitems_model->get_rows();

        $this->load->library('parser');
        $this->load->library('pagination');


        $count = $this->sentitems_model->count();


        $config['base_url'] = 'http://127.0.0.1/iprod/sent_items/index';
        $config['total_rows'] = $count;

        $this->pagination->initialize($config);

        $d['page_links'] = $this->pagination->create_links();

        $data = array(
            'title' => 'Sent Message SMS Server',
            'judul' => 'SENT MESSAGE',
            'content' => $this->load->view('sentitems/view_sentitems', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }
}
?>