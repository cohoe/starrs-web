<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Address extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_setSubHeader("Systems");
		$this->_addScript("/js/systems.js");
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
		$this->_addAction('DNS Records',"/dns/records/view/".rawurlencode($intAddr->get_address()),"primary");
		$this->_addAction('Renew',"/address/renew/".rawurlencode($intAddr->get_address()));

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
					$this->_post('mac'),
					$this->_post('address'),
					$this->_post('config'),
					$this->_post('class'),
					$this->_post('isprimary'),
					$this->_post('comment'),
					$this->_post('renew_date')
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
			$viewData['mac'] = $int->get_mac();
			$viewData['ints'] = array();
			$viewData['configs'] = $this->api->dhcp->get->configtypes();
			$viewData['date'] = $this->api->systems->get->defaultRenewDate($int->get_system_name());
			$viewData['user'] = $this->user;
			try {
				$viewData['ranges'] = $this->api->ip->get->ranges();
			}
			catch(ObjectNotFoundException $e) { $this->_exit(new Exception("No IP ranges configured! Set up at least one IP range before attempting to create an address")); return; }
			catch(Exception $e) { $this->_exit($e); return; }
			try {
				$viewData['classes'] = $this->api->dhcp->get->classes();
			}
			catch(ObjectNotFoundException $e) { $this->_exit(new Exception("No DHCP classes configured! Set up at least one class before attempting to create an address")); return; }
			catch(Exception $e) { $this->_exit($e); return; }
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveuser());
			foreach($systems as $sys) {
				$viewData['ints'] = array_merge($viewData['ints'],$this->api->systems->get->interfacesBySystem($sys->get_system_name()));
			}

			// Content
			$content = $this->load->view('interfaceaddress/create',$viewData,true);
			$content .= $this->forminfo;
	
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

			if($intAddr->get_address() != $this->_post('address')) {
				try { $intAddr->set_address($this->_post('address')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_config() != $this->_post('config')) {
				try { $intAddr->set_config($this->_post('config')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_class() != $this->_post('class')) {
				try { $intAddr->set_class($this->_post('class')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_isprimary() != $this->_post('isprimary')) {
				try { $intAddr->set_isprimary($this->_post('isprimary')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_comment() != $this->_post('comment')) {
				try { $intAddr->set_comment($this->_post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_mac() != $this->_post('mac')) {
				try { $intAddr->set_mac($this->_post('mac')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($intAddr->get_renew_date() != $this->_post('renew_date')) {
				try { $intAddr->set_renew_date($this->_post('renew_date')); }
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
			$viewData['intAddr'] = $intAddr;
			$viewData['ints'] = array();
			try {
				$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveuser());
				foreach($systems as $sys) {
					$viewData['ints'] = array_merge($viewData['ints'],$this->api->systems->get->interfacesBySystem($sys->get_system_name()));
				}
			}
			catch(ObjectNotFoundException $e) { $viewData['ints'][] = $int; }
			catch(Exception $e) { $this->_exit($e); return; }

			try {
				$viewData['configs'] = $this->api->dhcp->get->configtypes();
				$viewData['ranges'] = $this->api->ip->get->ranges();
				$viewData['classes'] = $this->api->dhcp->get->classes();
				$viewData['user'] = $this->user;
			}
			catch (Exception $e) { $this->_exit($e); return; }

			// Content
			$content = $this->load->view('interfaceaddress/modify',$viewData,true);
			$content .= $this->forminfo;

			// Render
			$this->_render($content);
		}
	}

	public function remove($address) {
		// Decode
		$address = rawurldecode($address);

		// Instantiate
		try {
			$intAddr = $this->api->systems->get->interfaceaddressByAddress($address);
		} 
		catch(Exception $e) { $this->_error($e); return; }
		
		// Remove
		if($this->input->post('confirm')) {
			try {
				$this->api->systems->remove->interfaceaddress($intAddr->get_address());
				$this->_sendClient("/addresses/view/".rawurlencode($intAddr->get_mac()));
				return;
			}
			catch (Exception $e) { $this->_error($e); return; }
		} else {
			$this->_error(new Exception("No cmonfirmation"));
		}
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

	public function renew($address) {
		// Decode
		$address = rawurldecode($address);

		if($address == 'all') {
			try {
				$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
				foreach($systems as $sys) {
					try {
						$intAddrs = $this->api->systems->get->interfaceaddressesBySystem($sys->get_system_name());
						foreach($intAddrs as $intAddr) {
							try {
								$this->api->systems->renew($intAddr->get_address());
							}
							catch(ObjectNotFoundException $e) {}
							catch(Exception $e) { $this->_error($e); return; }
						}
					}
					catch(ObjectNotFoundException $e) {}
					catch(Exception $e) { $this->_error($e); return; }
				}
			}
			catch(ObjectNotFoundException $e) {}
			catch(Exception $e) { $this->_error($e); return; }
			print "Added another interval to all of {$this->user->getActiveUser()}'s systems renew dates.";
			return;
		}

		// Instantiate
		try {
			$intAddr = $this->api->systems->get->interfaceaddressByAddress($address);
			$this->api->systems->renew($intAddr->get_address());
			print "Added another interval to {$intAddr->get_address()}'s renew date.";
		}
		catch(Exception $e) { $this->_error($e); return; }

	}
}

/* End of file address.php */
/* Location: ./application/controllers/address.php */
