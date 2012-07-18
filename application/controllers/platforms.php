<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Platforms extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_setSubHeader("Platforms");
		$this->_addTrail("Platforms","/platforms/view/");
	}

	public function index() {
		$this->_sendClient("/platforms/view/");
	}

	public function view() {
		// Actions
		$this->_addAction("Create","/platform/create/");

		// Sidebar
		try {
			$ps = $this->api->systems->get->platforms();
		}
		catch(ObjectNotFoundException $e) { $ps = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		foreach($ps as $p) {
			$this->_addSidebarItem($p->get_platform_name(),"/platform/view/".rawurlencode($p->get_platform_name()),"share");
		}

		// Content
		$content = $this->load->view('platform/information',null,true);

		// Render
		$this->_render($content);
	}
}

/* End of file platform.php */
/* Location: ./application/controllers/platform.php */
