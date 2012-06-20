<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bootstrap extends CI_Controller {

	public function index()
	{
		$navbar = $this->load->view('bootstrap/navbar',null,true);
		$sidebar = $this->load->view('bootstrap/sidebar',null,true);
		$content = $this->load->view('bootstrap/content',null,true);
		$this->load->view('bootstrap/main',array('navbar'=>$navbar,'sidebar'=>$sidebar,'content'=>$content));
	}
}

/* End of file bootstrap.php */
/* Location: ./application/controllers/bootstrap.php */
