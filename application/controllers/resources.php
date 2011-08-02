<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");
/**
 * 
 */
class Resources extends ImpulseController {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		// Navbar
		$navOptions['Site Configuration'] = "/admin/configuration/view/site";
	
		// Load view data
		$info['header'] = $this->load->view('core/header',"",TRUE);
		$info['sidebar'] = $this->load->view('core/sidebar',"",TRUE);
		$info['title'] = "IMPULSE Administration";
		$navbar = new Navbar("Administration", null, $navOptions);
		
		// More view data
		$info['navbar'] = $this->load->view('core/navbar',array("navbar"=>$navbar),TRUE);
		$info['data'] = '<a href="/resources/subnets/">Subnets</a>';

		// Load the main view
		$this->load->view('core/main',$info);
	}
}
/* End of file resources.php */
/* Location: ./application/controllers/resources.php */