<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Classes extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DHCP");
		$this->_setSubHeader("Classes");
		$this->_addTrail("DHCP","/dhcp");
		$this->_addTrail("classes","/dhcp/classes/view/");
	}

	public function index() {
		$this->_sendClient("/dhcp/classes/view/");
	}

	public function view() {
		// Actions
		$this->_addAction("Create","/dhcp/class/create/");

		// Sidebar
		$this->_addSidebarHeader("CLASSES");
		try {
			$classes = $this->api->dhcp->get->classes();
			foreach($classes as $c) {
				$this->_addSidebarItem($c->get_class(),"/dhcp/class/view/".rawurlencode($c->get_class()),"briefcase");
			}
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_exit($e); return; }

		// Content
		$content = $this->load->view('dhcp/class/information',null,true);

		// Render
		$this->_render($content);
	}
}

/* End of file classes.php */
/* Location: ./application/controllers/dhcp/classes.php */
