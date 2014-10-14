<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Hk extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('hk_model');
        $this->load->helper('url');
    }

    public function index($tahun = 0)
    {
        $this->load->library('parser');
        
        $d['query'] = $this->hk_model->get_last_ten($tahun);
        $d['rows'] = $this->hk_model->get_rows($tahun);
        $d['tahun'] = $this->hk_model->get_tahun_all();

        $data = array(
            'title' => 'Hari Kerja',
            'judul' => 'Hari Kerja',
            'content' => $this->load->view('hk/view_hk', $d, TRUE)
        );
        $this->parser->parse('template', $data);
    }

    public function load($tahun = 0){
        $d['query'] = $this->hk_model->get_last_ten($tahun);
        $d['rows'] = $this->hk_model->get_rows($tahun);
        $d['tahun'] = $this->hk_model->get_tahun_all();

        $this->load->view('hk/show_hk', $d);
    }

    public function submit($tahun) {
        if ($this->input->post('ajax')) {
            if ($this->input->post('edit')) {
                $this->hk_model->update();
                $this->load($tahun);
            } else {
                $this->hk_model->save();
                $this->load($tahun);
            }
        }
    }

    public function cek_data($tahun, $bulan){
        $cek = $this->hk_model->cek_data($tahun, $bulan);
        echo $cek;
    }

    public function delete($tahun) {
        $this->hk_model->delete();
        $d = $this->load($tahun);
    }

    function test($str){
        ?><script>alert("<?=$str;?>");</script><?php
    }
}
?>