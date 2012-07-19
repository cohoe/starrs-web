<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class InterfaceController extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_setSubHeader("Systems");
		$this->_addScript("/js/systems.js");
	}

	public function view($mac) {
		// Decode
		$mac = rawurldecode($mac);

		// Instantiate
		try {
			$int = $this->api->systems->get->interfaceByMac($mac);
		}
		catch(Exception $e) {
			$this->_exit($e);
			return;
		}

		// Breadcrumb Trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail($int->get_system_name(),"/system/view/{$int->get_system_name()}");
		$this->_addTrail("Interfaces","/interfaces/view/{$int->get_system_name()}");
		$this->_addTrail("$mac","/interface/view/".rawurlencode($mac));

		// Actions
		$this->_addAction('Add Address',"/address/create/".rawurlencode($mac),"success");
		if($this->user->isAdmin()) {
			$this->_addAction("Locate","/cam/locate/".rawurlencode($mac));
		}
		$this->_addAction('Modify',"/interface/modify/".rawurlencode($mac));
		$this->_addAction('Remove',"/interface/remove/".rawurlencode($mac));

		// Content
		$content = $this->load->view('interface/detail',array("int"=>$int),true);

		// Sidebar
		$recs = array();

		$this->_addSidebarHeader("ADDRESSES","/addresses/view/".rawurlencode($int->get_mac()));
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

		// Render
		$this->_render($content);
	}

	public function create($systemName) {
		$systemName = rawurldecode($systemName);
		try {
			$sys = $this->api->systems->get->systemByName($systemName);
		}
		catch (Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			try {
				$int = $this->api->systems->create->_interface(
					$this->input->post('systemName'),
					$this->input->post('mac'),
					$this->input->post('name'),
					$this->input->post('comment')
				);
				$this->_sendClient("/interface/view/".rawurlencode($int->get_mac()));
			}
			catch (Exception $e) { $this->_error($e); }
		}
		else {
			// Breadcrumb Trail
			$this->_addTrail('Systems',"/systems");
			$this->_addTrail($sys->get_system_name(),"/system/view/{$sys->get_system_name()}");

			// View data
			$viewData['systemName'] = $systemName;
			try {
				$viewData['systems'] = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			}
			catch (ObjectNotFoundException $e) {}
			catch (Exception $e) { $this->_exit($e); return; }

			// Content
			$content = $this->load->view('interface/create',$viewData,true);
			$content .= $this->forminfo;

			// Render
			$this->_render($content);
		}
	}

	public function modify($mac) {
		$mac = rawurldecode($mac);
		try {
			$int = $this->api->systems->get->interfaceByMac($mac);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();
			if($int->get_system_name() != $this->input->post('systemName')) {
				try { $int->set_system_name($this->input->post('systemName')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($int->get_name() != $this->input->post('name')) {
				try { $int->set_name($this->input->post('name')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($int->get_comment() != $this->input->post('comment')) {
				try { $int->set_comment($this->input->post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($int->get_mac() != $this->input->post('mac')) {
				try { $int->set_mac($this->input->post('mac')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
			}
			else {
				$this->_sendClient("/interface/view/".rawurlencode($int->get_mac()));
			}
		}
		else {
			// Breadcrumb Trail
			$this->_addTrail('Systems',"/systems");
			$this->_addTrail($int->get_system_name(),"/system/view/{$int->get_system_name()}");
			$this->_addTrail("Interfaces","/interfaces/view/{$int->get_system_name()}");
			$this->_addTrail("$mac","/interface/view/".rawurlencode($mac));

			// View data
			$viewData['int'] = $int;
			try {
				$viewData['systems'] = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			}
			catch (ObjectNotFoundException $e) {}
			catch (Exception $e) { $this->_exit($e); return; }

			// Content
			$content = $this->load->view('interface/modify',$viewData,true);
			$content .= $this->forminfo;

			// Done
			$this->_render($content);
		}
	}

	public function remove($mac) {
		// Decode
		$mac = rawurldecode($mac);

		// Instantiate
		try {
			$int = $this->api->systems->get->interfaceByMac($mac);
		}
		catch (Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->systems->remove->_interface($int->get_mac());
				$this->_sendClient("/interfaces/view/".rawurlencode($int->get_system_name()));
			}
			catch (Exception $e) {
				$this->_error($e);
			}
		}
		else {
			$this->_error(new Exception("No confirmation"));
		}
	}
}

/* End of file interfacecontroller.php */
/* Location: ./application/controllers/interfacecontroller.php */
