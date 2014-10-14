<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package archieve
 * @modified Sep 6, 2010
 */

class Mainload extends CI_Controller{

    public function __construct() {
        parent::__construct();
		$this->load->model('harian_model');
    }
    
    public function index()
    {
        $this->load->view('mainload', '');
    }

}
?>