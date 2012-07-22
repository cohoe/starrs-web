<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Switchports extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Network");
		$this->_setSubHeader("Switchports");
		$this->_addTrail("Network","/network");
		$this->_addTrail("Switchports","/network/switchports");
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
			$this->_addSidebarItem($nsys->get_system_name(),"/network/switchports/view/".rawurlencode($nsys->get_system_name()),"hdd");
		}

		$content = $this->load->view('switchport/information',null,true);
		
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

		// Trail
		$this->_addTrail($sys->get_system_name(),"/network/snmp/view/".rawurlencode($sys->get_system_name()));

		// Action
		$this->_addAction("SNMP","/network/snmp/view/".rawurlencode($sys->get_system_name()),"primary");
		$this->_addAction("CAM Table","/network/cam/view/".rawurlencode($sys->get_system_name()),"primary");
		$this->_addAction("Reload","/network/switchports/reload/".rawurlencode($sys->get_system_name()));

		// Sidebar
		$this->_addSidebarHeader("SYSTEMS");
		foreach($systems as $nsys) {
			if($nsys->get_system_name() == $sys->get_system_name()) {
				$this->_addSidebarItem($nsys->get_system_name(),"/network/switchports/view/".rawurlencode($nsys->get_system_name()),"hdd",1);
			} else {
				$this->_addSidebarItem($nsys->get_system_name(),"/network/switchports/view/".rawurlencode($nsys->get_system_name()),"hdd");
			}
		}

		try {
			$ifs = $this->api->network->get->switchports($sys->get_system_name());

			// Viewdata
			$viewData['sys'] = $sys;
			$viewData['ifs'] = $ifs;

			// Content
			$content = $this->load->view('switchport/detail',$viewData,true);
		}
		catch(ObjectNotFoundException $e) {
			// Content
			$content = $this->_renderException($e);
		}
		catch(Exception $e) { $content = $this->_renderException($e); }

		// Render
		$this->_render($content);
	}

	public function create($system) {
		// Decode
		$system = rawurldecode($system);

		// Instantiate
		try {
			$sys = $this->api->systems->get->systemByName($system);
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post()) {
			$snmp = $this->api->network->create->snmp(
				$sys->get_system_name(),
				$this->_post('address'),
				$this->_post('ro'),
				$this->_post('rw')
			);
			$this->_sendClient("/snmp/view/".rawurlencode($sys->get_system_name()));
			return;
		}

		$viewData['sys'] = $sys;

		$content = $this->load->view('snmp/create',$viewData,true);
		$this->_renderSimple($content);
	}

	public function remove($system) {
		// Decode
		$system = rawurldecode($system);

		// Instantiate
		try {
			$sys = $this->api->systems->get->systemByName($system);
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->network->remove->snmp($sys->get_system_name());
				$this->_sendClient("/snmp/view/".rawurlencode($sys->get_system_name()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		} else {
			$this->_error(new Exception("No confirmation")); return;
		}
	}

	public function modify($system) {
		// Decode
		$system = rawurldecode($system);

		// Instantiate
		try {
			$sys = $this->api->systems->get->systemByName($system);
			$snmp = $this->api->network->get->snmp($sys->get_system_name());
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post()) {
			$err = array();

			if($snmp->get_ro_community() != $this->_post('ro')) {
				try { $snmp->set_ro_community($this->_post('ro')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($snmp->get_rw_community() != $this->_post('rw')) {
				try { $snmp->set_rw_community($this->_post('rw')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err); return;
			}

			$this->_sendClient("/snmp/view/".rawurlencode($sys->get_system_name()));
			return;
		}

		$viewData['sys'] = $sys;
		$viewData['snmp'] = $snmp;

		$content = $this->load->view('snmp/modify',$viewData,true);

		$this->_renderSimple($content);
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
               $this->api->network->reload_switchports($sys->get_system_name());
               $this->_sendClient("/network/switchports/view/".rawurlencode($sys->get_system_name()));
               return;
          }
          catch(Exception $e) { $this->_error($e); return; }
     }
}

/* End of file snmp.php */
/* Location: ./application/controllers/network/snmp.php */
