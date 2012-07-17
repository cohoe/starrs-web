<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Groups extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Management");
		$this->_setSubHeader("Groups");
		$this->_addTrail("Groups","/groups");
	}

	public function index() {
		$this->_sendClient("/groups/view/");
	}

	public function view() {
		// Instantiate
		try {
			$gs = $this->api->get->groups();
		}
		catch(ObjectNotFoundException $e) { $gs = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Actions
		$this->_addAction("Create","/group/create");

		// Sidebar
		$this->_addSidebarHeader("GROUPS");
		foreach($gs as $g) {
			$this->_addSidebarItem($g->get_group(),"/group/view/".rawurlencode($g->get_group()),"book");
		}

		// Content
		$content = $this->load->view('group/information',null,true);

		// Render
		$this->_render($content);
	}
}

/* End of file groups.php */
/* Location: ./application/controllers/groups.php */
