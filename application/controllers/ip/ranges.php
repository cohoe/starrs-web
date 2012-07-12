<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Ranges extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("IP");
		$this->_addTrail("IP","/ip");
		$this->_addTrail("Ranges","/ip/ranges");
	}

	public function index() {
		$this->_sendClient("/ip/ranges/view/");
	}

	public function view() {

		// Sidebar
		$this->_addSidebarHeader("RANGES");
		try {
			$ranges = $this->api->ip->get->ranges(); 
		}
		catch(ObjectNotFoundException $e) { $ranges = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		foreach($ranges as $r) {
			$this->_addSidebarItem($r->get_name(),"/ip/range/view/".rawurlencode($r->get_name()),"resize-full");
		}

		// Content
		$content = $this->load->view('ip/range/information',null,true);

		// Render
		$this->_render($content);
	}
}

/* End of file ranges.php */
/* Location: ./application/controllers/ranges.php */
