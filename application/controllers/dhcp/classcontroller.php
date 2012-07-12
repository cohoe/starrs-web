<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Classcontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DHCP");
		$this->_addTrail("DHCP","/dhcp");
		$this->_addTrail("Classes","/dhcp/classes/view/");
	}

	public function index() {
		$this->_sendClient("/dhcp/classes/view/");
	}

	public function view($class) {
		// Decode
		$class = rawurldecode($class);

		// Instantiate
		try {
			$c = $this->api->dhcp->get->_class($class);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($c->get_class(),"/dhcp/class/view/".rawurlencode($c->get_class()));

		// Actions
		$this->_addAction("Modify","/dhcp/class/modify/".rawurlencode($c->get_class()));
		$this->_addAction("Remove","/dhcp/class/remove/".rawurlencode($c->get_class()));

		// Viewdata
		$viewData['c'] = $c; 

		// Content
		$content = $this->load->view('dhcp/class/detail',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$c = $this->api->dhcp->create->_class(
					$this->_post('class'),
					$this->_post('comment')
				);
				$this->_sendClient("/dhcp/class/view/".rawurlencode($c->get_class()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		
		$content = $this->load->view('dhcp/class/create',null,true);
		$content .= $this->forminfo;
		$this->_render($content);
	}
}

/* End of file classcontroller.php */
/* Location: ./application/controllers/dhcp/classcontroller.php */
