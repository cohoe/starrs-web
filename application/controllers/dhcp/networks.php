<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Networks extends ImpulseController {

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

	public function view() {
		// Actions
		$this->_addAction("Create","/dhcp/network/create/");

		// Sidebar
		$this->_addSidebarHeader("SHARED NETWORKS");
		try {
			$networks = $this->api->dhcp->get->networks();
			foreach($networks as $n) {
				$this->_addSidebarItem($n->get_name(),"/dhcp/network/view/".rawurlencode($n->get_name()),"briefcase");
			}
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_exit($e); return; }

		// Content
		$content = $this->load->view('dhcp/network/information',null,true);

		// Render
		$this->_render($content);
	}
}

/* End of file networks.php */
/* Location: ./application/controllers/dhcp/networks.php */
