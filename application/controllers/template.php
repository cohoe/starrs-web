<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Template extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Header");
		$this->_setSubHeader("Object");
		$this->_addTrail("Header","#");
	}

	public function index() {
		$this->_sendClient("#");
	}

	public function view($object) {
		// Decode
		$object = rawurldecode($object);

		// Instantiate
		try {
			$obj = $this->api->get->object($object);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($obj->get_name(),"#");

		// Actions
		$this->_addAction("Modify","#");
		$this->_addAction("Remove","#");

		// Viewdata
		$viewData['foo'] = "bar";

		// Content
		$content = $this->load->view('#',$viewData,true);

		// Render
		$this->_render($content);
	}
}

/* End of file template.php */
/* Location: ./application/controllers/template.php */
