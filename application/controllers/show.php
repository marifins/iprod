<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */
class Show extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function direksi() {
        $this->load->view('show/direksi', "");
    }

    public function komisaris() {
        $this->load->view('show/komisaris', "");
    }
    
    public function pengumuman() {
        $this->load->view('show/pengumuman', "");
    }

}

?>