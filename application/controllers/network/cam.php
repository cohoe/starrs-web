<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Cam extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Network");
		$this->_setSubHeader("CAM");
		$this->_addTrail("Network","/");
		$this->_addTrail("CAM","/network/cam");
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
			$this->_addSidebarItem($nsys->get_system_name(),"/network/cam/view/".rawurlencode($nsys->get_system_name()),"hdd");
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
		}
		catch(Exception $e) { $this->_exit($e); return; }

		try {
			$systems = $this->api->systems->get->systemsByFamily('Network',$this->user->getActiveUser());
		}
		catch(ObjectNotFoundException $e) { $systems = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		try {
			$cam = $this->api->network->get->cam($sys->get_system_name());
		}
		catch(ObjectNotFoundException $e) { $cam = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($sys->get_system_name(),"/network/cam/view/".rawurlencode($sys->get_system_name()));

		// Actions
		$this->_addAction("SNMP","/network/snmp/view/".rawurlencode($sys->get_system_name()),"primary");
		$this->_addAction("Switchports","/network/switchports/view/".rawurlencode($sys->get_system_name()),"primary");
		$this->_addAction("Reload","/network/cam/reload/".rawurlencode($sys->get_system_name()));

		// Sidebar
		$this->_addSidebarHeader("SYSTEMS");
		foreach($systems as $nsys) {
			if($nsys->get_system_name() == $sys->get_system_name()) {
				$this->_addSidebarItem($nsys->get_system_name(),"/network/cam/view/".rawurlencode($nsys->get_system_name()),"hdd",1);
			} else {
				$this->_addSidebarItem($nsys->get_system_name(),"/network/cam/view/".rawurlencode($nsys->get_system_name()),"hdd");
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
			$this->_sendClient("/network/cam/view/".rawurlencode($sys->get_system_name()));
			return;
		}
		catch(Exception $e) { $this->_error($e); return; }
	}

	public function locate($mac) {
		// Decode
		$mac = rawurldecode($mac);

		try {
			$int = $this->api->systems->get->interfaceByMac($mac);
		}
		catch(Exception $e) { $this->_exit($e); return; }
		
		$this->_addSidebarHeader("ADDRESSES","/addresses/view/".rawurlencode($int->get_mac()));
		$recs = array();
          try {
               $intAddrs = $this->api->systems->get->interfaceaddressesByMac($int->get_mac());
               foreach($intAddrs as $intAddr) {
                    $this->_addSidebarItem($intAddr->get_address(),"/address/view/".rawurlencode($intAddr->get_address()),"globe");
                    try {
                         $recs = array_merge($recs,$this->api->dns->get->recordsByAddress($intAddr->get_address()));
                    }
                    catch (Exception $e) {}
               }
          }
          catch(ObjectNotFoundException $e) {}
          catch(Exception $e) {
               $this->_exit($e);
               return;
          }

          $this->_addSidebarHeader("DNS RECORDS");
          $this->_addSidebarDnsRecords($recs);

		// Trail
		$this->_addTrail($int->get_mac(),"/interface/view/".rawurlencode($int->get_mac()));

		// Actions

		try {
			$ports = $this->api->network->get->interface_ports($mac);
			foreach($ports as $p) {
				$this->_addContentToList($this->load->view('cam/locate',array('p'=>$p),true),2);
			}

			$content = $this->_renderContentList(2);
		}
		catch(ObjectNotFoundException $e) { $content = $this->_renderException(new ObjectNotFoundException("No CAM table entries were found!")); }
		catch(Exception $e) { $content = $this->_renderException($e); }

		$this->_render($content);
	}
}

/* End of file cam.php */
/* Location: ./application/controllers/network/cam.php */
