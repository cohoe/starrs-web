<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Subnetcontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Header");
		$this->_addTrail("Header","#");
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
		#$this->_addTrail($obj->get_name(),"#");

		// Actions
		$this->_addAction("Modify","#");
		$this->_addAction("Remove","#");

		// Viewdata

		// Content
	#	$content = $this->load->view('#',$viewData,true);
		$content = "foo";

		// Render
		$this->_render($content);
	}
}

/* End of file subnetcontroller.php */
/* Location: ./application/controllers/subnetcontroller.php */
