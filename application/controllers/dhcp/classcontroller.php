<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Classcontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DHCP");
		$this->_setSubHeader("Classes");
		$this->_addTrail("DHCP","/dhcp");
		$this->_addTrail("Classes","/dhcp/classes/view/");
		$this->_addScript("/js/ip.js");
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
			$cls = $this->api->dhcp->get->classes();
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($c->get_class(),"/dhcp/class/view/".rawurlencode($c->get_class()));

		// Actions
		$this->_addAction("Create DHCP Option","/dhcp/classoption/create/".rawurlencode($c->get_class()),"success");
		$this->_addAction("Modify","/dhcp/class/modify/".rawurlencode($c->get_class()));
		$this->_addAction("Remove","/dhcp/class/remove/".rawurlencode($c->get_class()));

		// Sidebar
		$this->_addSidebarHeader("CLASSES");
		foreach($cls as $cla) {
			if($cla->get_class() == $c->get_class()) {
				$this->_addSidebarItem($cla->get_class(),"/dhcp/class/view/".rawurlencode($cla->get_class()),"briefcase",1);
			} else {
				$this->_addSidebarItem($cla->get_class(),"/dhcp/class/view/".rawurlencode($cla->get_class()),"briefcase");
			}
		}

		// Viewdata
		$viewData['c'] = $c; 
		
		try {
			$opts = $this->api->dhcp->get->classoptions($c->get_class());
		}
		catch(ObjectNotFoundException $e) { $opts = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Content
		$content = "<div class=\"span7\">";
		$content .= $this->load->view('dhcp/class/detail',$viewData,true);
		$content .= $this->_renderOptionView($opts);
		$content .= "</div>";

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

	public function modify($class) {
		// Decode
		$class = rawurldecode($class);

		// Instantiate
		try {
			$c = $this->api->dhcp->get->_class($class);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();

			if($c->get_class() != $this->_post('class')) {
				try { $c->set_class($this->_post('class')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($c->get_comment() != $this->_post('comment')) {
				try { $c->set_comment($this->_post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
				return;
			}

			$this->_sendClient("/dhcp/class/view/".rawurlencode($c->get_class()));
			return;
		}

		// Trail
		$this->_addTrail($c->get_class(),"/dhcp/class/view/".rawurlencode($c->get_class()));

		// Viewdata
		$viewData['c'] = $c; 

		// Content
		$content = $this->load->view('dhcp/class/modify',array('c'=>$c),true);
		$content .= $this->forminfo;

		// Render
		$this->_render($content);
	}

	public function remove($class) {
		// Decode
		$class = rawurldecode($class);

		// Instantiate
		try {
			$c = $this->api->dhcp->get->_class($class);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->dhcp->remove->_class($c->get_class());
				$this->_sendClient("/dhcp/classes/view");
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("No confirmation"));
			return;
		}
	}
}

/* End of file classcontroller.php */
/* Location: ./application/controllers/dhcp/classcontroller.php */
