<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *
 * @copyright 2010
 * @author Muhammad Arifin Siregar
 * @package default_template
 * @modified Sep 2, 2010
 */

 class Template_Default extends CI_Controller
 {
	 public function index()
	 {
		$this->load->view('template');
	  }
 }

?>
