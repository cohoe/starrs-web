<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Subnetcontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("IP");
		$this->_addTrail("IP","/ip");
		$this->_addTrail("Subnets","/ip/subnets/");
	}

	public function index() {
		$this->_sendClient("#");
	}

	public function view($subnet) {
		// Decode
		$subnet = rawurldecode($subnet);

		// Instantiate
		try {
			$snet = $this->api->ip->get->subnet($subnet);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($snet->get_subnet(),"/ip/subnet/view/".rawurlencode($snet->get_subnet()));

		// Actions
		$this->_addAction("Modify","#");
		$this->_addAction("Remove","#");

		// Viewdata
		$viewData['snet'] = $snet;

		// Content
		$content = $this->load->view('ip/subnet/detail',$viewData,true);

		// Sidebar
		$this->_addSidebarHeader("RANGES");

		// Render
		$this->_render($content);
	}
}

/* End of file subnetcontroller.php */
/* Location: ./application/controllers/subnetcontroller.php */
