<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Cam extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Network");
		$this->_setSubHeader("CAM");
		$this->_addTrail("Network","/");
		$this->_addTrail("CAM","/cam");
		$this->_addScript("/js/snmp.js");
	}

	public function index() {
		$this->_addSidebarHeader("SYSTEMS");
		try {
			$systems = $this->api->systems->get->systemsByFamily('Network',$this->user->getActiveUser());
		}
		catch(ObjectNotFoundException $e) { $systems = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		foreach($systems as $nsys) {
			$this->_addSidebarItem($nsys->get_system_name(),"/cam/view/".rawurlencode($nsys->get_system_name()),"hdd");
		}

		$content = $this->load->view('cam/information',null,true);
		$this->_render($content);
	}

	public function view($system) {
		// Decode
		$system = rawurldecode($system);

		// Instantiate
		try {
			$sys = $this->api->systems->get->systemByName($system);
			$systems = $this->api->systems->get->systemsByFamily('Network',$this->user->getActiveUser());
		}
		catch(Exception $e) { $this->_exit($e); return; }

		try {
			$cam = $this->api->network->get->cam($sys->get_system_name());
		}
		catch(ObjectNotFoundException $e) { $cam = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($sys->get_system_name(),"/cam/view/".rawurlencode($sys->get_system_name()));

		// Actions
		$this->_addAction("Reload","/cam/reload/".rawurlencode($sys->get_system_name()));

		// Sidebar
		$this->_addSidebarHeader("SYSTEMS");
		foreach($systems as $nsys) {
			if($nsys->get_system_name() == $sys->get_system_name()) {
				$this->_addSidebarItem($nsys->get_system_name(),"/cam/view/".rawurlencode($nsys->get_system_name()),"hdd",1);
			} else {
				$this->_addSidebarItem($nsys->get_system_name(),"/cam/view/".rawurlencode($nsys->get_system_name()),"hdd");
			}
		}

		// Viewdata
		$viewData['sys'] = $sys;
		$viewData['cam'] = $cam;

		// Content
		$content = $this->load->view('cam/detail',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function reload($system) {
		// Decode
		$system = rawurldecode($system);

		// Instantiate
		try {
			$sys = $this->api->systems->get->systemByName($system);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		try {
			$this->api->network->reload_cam($sys->get_system_name());
			$this->_sendClient("/cam/view/".rawurlencode($sys->get_system_name()));
			return;
		}
		catch(Exception $e) { $this->_error($e); return; }
	}

	public function locate($mac) {
		// Decode
		$mac = rawurldecode($mac);
		
		try {
			$ports = $this->api->network->get->interface_ports($mac);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		$this->_sidebarBlank();

		foreach($ports as $p) {
			$this->_addContentToList($this->load->view('cam/locate',array('p'=>$p),true),2);
		}

		$content = $this->_renderContentList(2);
		
		$this->_render($content);
	}
}

/* End of file cam.php */
/* Location: ./application/controllers/cam.php */
