<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Info extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('info_model');
        $this->load->helper('url');
        $this->load->library('auth');
    }

    public function index($page = 0)
    {
        $this->load->library('parser');
        $d = $this->getpagelink($page);
        $data = array(
            'title' => 'SMS Info',
            'judul' => '&nbsp;News Feed',
            'content' => $this->load->view('info/view_info', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function getpagelink($page = 0){
        $d['query'] = $this->info_model->get_last_ten(10,$page);
        $d['rows'] = $this->info_model->get_rows();
        $d['rows_level'] = $this->info_model->get_rows();

        
        $this->load->library('pagination');


        $count = $this->info_model->count();


        $config['base_url'] = 'http://127.0.0.1/iprod/info/index';
        $config['total_rows'] = $count;

        $this->pagination->initialize($config);

        $d['page_links'] = $this->pagination->create_links();
        return $d;
    }

    public function delete() {
        $this->info_model->delete();
        $d = $this->getpagelink(0);
        $this->load->view('info/show_info', $d);
    }
}
?>