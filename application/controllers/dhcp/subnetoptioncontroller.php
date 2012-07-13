<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Subnetoptioncontroller extends ImpulseController {

	public function create($subnet) {
		// Decode
		$subnet = rawurldecode($subnet);

		// Subnet
		try {
			$snet = $this->api->ip->get->subnet($subnet);
		}
		catch(Exception $e) { $this->_error($e); return; }

		// Create
		if($this->input->post()) {
			print "lol";
			return;
		}

		$content = $this->load->view('dhcp/option/create',null,true);

		$this->_renderSimple($content);
	}
	public function view() {
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
		$content .= $this->load->view('dhcp/optioncreate',null,true);

		// Render
		$this->_render($content);
	}
}

/* End of file subnetoption.php */
/* Location: ./application/controllers/dhcp/subnetoption.php */
