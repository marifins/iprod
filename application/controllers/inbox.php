<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Inbox extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('inbox_model');
        $this->load->helper('url');
    }

    public function index($page = 0)
    {
        $d['query'] = $this->inbox_model->get_last_ten(10,$page);
        $d['rows'] = $this->inbox_model->get_rows();

        $this->load->library('parser');
        $this->load->library('pagination');


        $count = $this->inbox_model->count();

        $base = base_url();
        $config['base_url'] = $base.'inbox/index';
        $config['total_rows'] = $count;
     
        $this->pagination->initialize($config);

        $d['page_links'] = $this->pagination->create_links();

        $data = array(
            'title' => 'Inbox SMS Server',
            'judul' => 'INBOX SMS',
            'content' => $this->load->view('inbox/view_inbox', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }
}
?>