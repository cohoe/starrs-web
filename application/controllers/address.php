<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Address extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
	}

	public function view($address) {
		// Decode
		$address = rawurldecode($address);

		// Instantiate
		try {
			$intAddr = $this->api->systems->get->interfaceaddressByAddress($address);
			$int = $this->api->systems->get->interfaceByMac($intAddr->get_mac());
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Breadcrumb Trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail($int->get_system_name(),"/system/view/{$int->get_system_name()}");
		$this->_addTrail("Interfaces","/interfaces/view/{$int->get_system_name()}");
		$this->_addTrail($int->get_mac(),"/interface/view/".rawurlencode($int->get_mac()));
		$this->_addTrail("Addresses","/addresses/view/".rawurlencode($int->get_mac()));
		$this->_addTrail($intAddr->get_address(),"/address/view/".rawurlencode($intAddr->get_address()));

		// Actions
		$this->_addAction('Modify',"/address/modify/".rawurlencode($intAddr->get_address()));
		$this->_addAction('Remove',"/address/remove/".rawurlencode($intAddr->get_address()));

		// Content
		$content = $this->load->view('interfaceaddress/detail',array("intAddr"=>$intAddr),true);

		// Sidebar
		try {
			$recs = $this->api->dns->get->recordsByAddress($intAddr->get_address());
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_exit($e); return; }

		$this->_addSidebarHeader("DNS RECORDS","/dns/records/view/".rawurlencode($intAddr->get_address()));
		$this->_addSidebarDnsRecords($recs);

		// Render
		$this->_render($content);
	}

	public function create($mac) {
		// Decode
		$mac = rawurldecode($mac);

		// Instantiate
		try {
			$int = $this->api->systems->get->interfaceByMac($mac);
		}
		catch (Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			try {
				$intAddr = $this->api->systems->create->interfaceaddress(
					$this->input->post('mac'),
					$this->input->post('address'),
					$this->input->post('config'),
					$this->input->post('class'),
					$this->input->post('isprimary'),
					$this->input->post('comment')
				);
				$this->_sendClient("/address/view/".rawurlencode($intAddr->get_address()));
			}
			catch (Exception $e) { $this->_error($e); }
		}
		else {
		// Trail
		$this->_addTrail("Systems","/systems");
		$this->_addTrail($int->get_system_name(),"/system/view/".rawurlencode($int->get_system_name()));
		$this->_addTrail("Interfaces","/interfaces/view/".rawurlencode($int->get_system_name()));
		$this->_addTrail($int->get_mac(),"/interface/view/".rawurlencode($int->get_mac()));

		// View Data
		try {
			$viewData['mac'] = $int->get_mac();
			$viewData['ints'] = array();
			$viewData['configs'] = $this->api->dhcp->get->configtypes();
			$viewData['ranges'] = $this->api->ip->get->ranges();
			$viewData['classes'] = $this->api->dhcp->get->classes();
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveuser());
			foreach($systems as $sys) {
				$viewData['ints'] = array_merge($viewData['ints'],$this->api->systems->get->interfacesBySystem($sys->get_system_name()));
			}
		}
		catch (Exception $e) { $this->_exit($e); return; }

		// Content
		$content = $this->load->view('interfaceaddress/create',$viewData,true);
		$content .= $this->load->view('core/forminfo',null,true);

		// Render
		$this->_render($content);
		}
	}

	public function modify($address) {
		// Decode
		$address = rawurldecode($address);
		// Instantiate

		try {
			$intAddr = $this->api->systems->get->interfaceaddressByAddress($address);
			$int = $this->api->systems->get->interfaceByMac($intAddr->get_mac());
		}
		catch (Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();

			if($intAddr->get_address() != $this->input->post('address')) {
				try { $intAddr->set_address($this->input->post('address')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_config() != $this->input->post('config')) {
				try { $intAddr->set_config($this->input->post('config')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_class() != $this->input->post('class')) {
				try { $intAddr->set_class($this->input->post('class')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_isprimary() != $this->input->post('isprimary')) {
				try { $intAddr->set_isprimary($this->input->post('isprimary')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_comment() != $this->input->post('comment')) {
				try { $intAddr->set_comment($this->input->post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_mac() != $this->input->post('mac')) {
				try { $intAddr->set_mac($this->input->post('mac')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
			}
			else {
				$this->_sendClient("/address/view/".rawurlencode($intAddr->get_address()));
			}
		}
		else {
			// Trail
			$this->_addTrail("Systems","/systems");
			$this->_addTrail($int->get_system_name(),"/system/view/".rawurlencode($int->get_system_name()));
			$this->_addTrail("Interfaces","/interfaces/view/".rawurlencode($int->get_system_name()));
			$this->_addTrail($int->get_mac(),"/interface/view/".rawurlencode($int->get_mac()));
			$this->_addTrail("Addresses","/addresses/view/".rawurlencode($int->get_mac()));
			$this->_addTrail($intAddr->get_address(),"/address/view/".rawurlencode($intAddr->get_address()));

			// View Data
			try {
				$viewData['intAddr'] = $intAddr;
				$viewData['ints'] = array();
				$viewData['configs'] = $this->api->dhcp->get->configtypes();
				$viewData['ranges'] = $this->api->ip->get->ranges();
				$viewData['classes'] = $this->api->dhcp->get->classes();
				$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveuser());
				foreach($systems as $sys) {
					$viewData['ints'] = array_merge($viewData['ints'],$this->api->systems->get->interfacesBySystem($sys->get_system_name()));
				}
			}
			catch (Exception $e) { $this->_exit($e); return; }

			// Content
			$content = $this->load->view('interfaceaddress/modify',$viewData,true);
			$content .= $this->load->view('core/forminfo',null,true);

			// Render
			$this->_render($content);
		}
	}

	public function remove($address) {
		// Decode
		$address = rawurldecode($address);
		
		// Remove
		try {
			$intAddr = $this->api->systems->get->interfaceaddressByAddress($address);
			$this->api->systems->remove->interfaceaddress($intAddr->get_address());
			$this->_sendClient("/addresses/view/".rawurlencode($intAddr->get_mac()));
		}
		catch (Exception $e) { $this->_error($e); }
	}

	public function getfromrange() {
		if($this->input->post()) {
			try {
				print $this->api->ip->get->address_from_range($this->input->post('range'));
			}
			catch (Exception $e) { print $e->getMessage(); }
		}
	}

	public function getrange() {
		if($this->input->post()) {
			try {
				print $this->api->ip->get->address_range($this->input->post('address'));
			}
			catch (Exception $e) { print $e->getMessage(); }
		}
	}
}

/* End of file address.php */
/* Location: ./application/controllers/address.php */
