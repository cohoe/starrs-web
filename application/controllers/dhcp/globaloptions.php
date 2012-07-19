<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Globaloptions extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DHCP");
		$this->_setSubHeader("Global Options");
		$this->_addTrail("DHCP","/dhcp");
		$this->_addTrail("Global Options","/dhcp/globaloptions/view");
		$this->_addScript("/js/ip.js");
	}

	public function index() {
		$this->_sendClient("/dhcp/globaloptions/view/");
	}

	public function view() {
		// Instantiate
		try {
			$opts = $this->api->dhcp->get->globaloptions();
		}
		catch(ObjectNotFoundException $e) { $opts = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		$this->_sidebarBlank();

		// Actions
		$this->_addAction("Create DHCP Option","/dhcp/globaloption/create","success");

		// Content
		$content = "<div class=\"span7\">";
		$content .= $this->_renderOptionView($opts);
		$content .= "</div>";

		// Render
		$this->_render($content);
	}
}

/* End of file template.php */
/* Location: ./application/controllers/template.php */
