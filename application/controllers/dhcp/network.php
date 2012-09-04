<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Network extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DHCP");
		$this->_setSubHeader("Networks");
		$this->_addTrail("DHCP","/dhcp");
		$this->_addTrail("Networks","/dhcp/networks/view/");
	}

	public function index() {
		$this->_sendClient("/dhcp/networks/view/");
	}

	public function view($name=null) {
		// Decode
		$name = rawurldecode($name);

		// Instantiate
		try {
			$sn = $this->api->dhcp->get->network($name);
		}
		catch(Exception $e) { $this->_exit($e); return; }
		
		// Actions
		$this->_addAction("Modify","/dhcp/network/modify/".rawurlencode($sn->get_name()));
		$this->_addAction("Remove","/dhcp/network/remove/".rawurlencode($sn->get_name()));

		// Sidebar
		$this->_addSidebarHeader("SUBNETS");
		try {
			$subnets = $this->api->dhcp->get->network_subnets($sn->get_name());
			foreach($subnets as $s) {
				$this->_addSidebarItem($s->get_subnet(), "/ip/subnet/view/".rawurlencode($s->get_subnet()),"tags");
			}
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_exit($e); return; }

		// Content
		#$content = $this->load->view('dhcp/network/information',null,true);
		$content = "lol";

		// Render
		$this->_render($content);
	}
}

/* End of file network.php */
/* Location: ./application/controllers/dhcp/network.php */
