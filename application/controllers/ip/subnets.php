<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Subnets extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("IP");
		$this->_setSubHeader("Subnets");
		$this->_addTrail("IP","/ip");
	}

	public function index() {
		$this->_sendClient("/ip/subnets/view");
	}

	public function view() {

		// Instantiate
		try {
			$snets = $this->api->ip->get->subnets();
		}
		catch(ObjectNotFoundException $e) { $snets = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail("Subnets","/ip/subnets/view/");

		// Actions
		$this->_addAction("Create","/ip/subnet/create");

		// Content
		$this->_addSidebarHeader("SUBNETS");
		foreach($snets as $snet) {
			$this->_addSidebarItem($snet->get_subnet(),"/ip/subnet/view/".rawurlencode($snet->get_subnet()),"tags");
		}

		$content = $this->load->view('ip/subnet/information',null,true);

		// Render
		$this->_render($content);
	}
}

/* End of file subnets.php */
/* Location: ./application/controllers/subnets.php */
