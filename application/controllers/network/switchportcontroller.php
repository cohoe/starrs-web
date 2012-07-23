<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Switchportcontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Header");
		$this->_setSubHeader("Object");
		$this->_addTrail("Header","#");
	}

	public function index() {
		$this->_sendClient("#");
	}

	public function view($system, $ifindex) {
		// Decode
		$system = rawurldecode($system);
		$ifindex = rawurldecode($ifindex);

		// Instantiate
		try {
			$sp = $this->api->network->get->switchport($system, $ifindex);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Viewdata
		$viewData['sp'] = $sp;
		$viewData['ifState'] = $this->ifState;

		// Content
		$content = $this->load->view('switchport/detail',$viewData,true);

		// Render
		$this->_renderSimple($content);
	}
}

/* End of file switchportcontroller.php */
/* Location: ./application/controllers/network/switchportcontroller.php */
