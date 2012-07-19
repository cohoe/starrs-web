<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Dhcpd extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DHCP");
		$this->_setSubHeader("dhcpd");
		$this->_addTrail("DHCP","/dhcp");
		$this->_addTrail("dhcpd","/dhcp/dhcpd/view");
	}

	public function index() {
		$this->_sendClient("/dhcp/dhcpd/view/");
	}

	public function view() {
		// Priv
		if(!$this->user->isAdmin()) {
			$this->_exit(new Exception("Only Admins can view the dhcpd config file"));
		}

		// Actions
		$this->_addAction("Generate","/dhcp/dhcpd/generate/");

		// Viewdata
		$viewData['file'] = $this->api->dhcp->get->dhcpdconfig();

		// Sidebar
		$this->_sidebarBlank();

		// Content
		$content = $this->load->view('dhcp/dhcpdconf',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function generate() {
		// Priv
		if(!$this->user->isAdmin()) {
			$this->_exit(new Exception("Only Admins can view the dhcpd config file"));
		}

		// Generate
		try {
			$this->api->dhcp->reload();
			$this->_sendClient("/dhcp/dhcpd/view");
		}
		catch(Exception $e) { $this->_exit($e); return; }
	}
}

/* End of file dhcpd.php */
/* Location: ./application/controllers/dhcp/dhcpd.php */
