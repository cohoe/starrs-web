<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Zonea extends DnsController {

	public function __construct() {
		parent::__construct();
		#$this->_addScript("/js/dns.js");
	}

	public function create($zone=null) {
		// Decode
		$zone = rawurldecode($zone);

		if($this->input->post()) {
			try {
				$za = $this->api->dns->create->zonea(
					$this->input->post('zone'),
					$this->input->post('address'),
					$this->_postToNull('ttl')
				);

				$this->_sendClient("/dns/zone/view/".rawurlencode($za->get_zone()));
			}
			catch (Exception $e) { $this->_error($e); return; }
		}

		try {
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			$intAddrs = array();
			foreach($systems as $sys) {
				try {
					$intAddrs = array_merge($intAddrs, $this->api->systems->get->interfaceaddressesBySystem($sys->get_system_name()));
				}
				catch (ObjectNotFoundException $e) {}
				catch (Exception $e) { $this->_exit($e); }
			}
		}
		catch(Exception $e) { $this->_exit($e); return; }

		$viewData['zone'] = $zone;
		$viewData['intAddrs'] = $intAddrs;

		$this->load->view('dns/zonea/create',$viewData);
	}

	public function view($zone=null,$address=null) {
		// Decode
		$zone = rawurldecode($zone);
		$address = rawurldecode($address);

		// Instantiate
		try {
			$za = $this->api->dns->get->zoneaByZoneAddress($zone,$address);
			$this->load->view('dns/zonea/detail',array('rec'=>$za));
		}
		catch(Exception $e) { $this->_error($e); return; }
	}

	public function remove($zone=null,$address=null) {
		// Decode
		$zone = rawurldecode($zone);
		$address = rawurldecode($address);

		// Instantiate
		try {
			$za = $this->api->dns->get->zoneaByZoneAddress($zone,$address);
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->dns->remove->zonea($za->get_zone(),$za->get_address());
				$this->_sendClient("/dns/zone/view/".rawurlencode($za->get_zone()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("no confirmation")); return;
		}
	}

	public function modify($zone,$address) {
		// Decode
		$zone = rawurldecode($zone);
		$address = rawurldecode($address);

		// Instantiate
		try {
			$za = $this->api->dns->get->zoneaByZoneAddress($zone,$address);
		}
		catch(Exception $e) { $this->_error($e); return; }
		
		if($this->input->post()) {
			$err = array();

			if($za->get_ttl() != $this->input->post('ttl')) {
				try { $za->set_ttl($this->input->post('ttl')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($za->get_address() != $this->input->post('address')) {
				try { $za->set_address($this->input->post('address')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($za->get_zone() != $this->input->post('zone')) {
				try { $za->set_zone($this->input->post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err); return;
			}

			$this->_sendClient("/dns/zone/view/".rawurlencode($za->get_zone()));
			return;
		}

		try {
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			$intAddrs = array();
			foreach($systems as $sys) {
				try {
					$intAddrs = array_merge($intAddrs, $this->api->systems->get->interfaceaddressesBySystem($sys->get_system_name()));
				}
				catch (ObjectNotFoundException $e) {}
				catch (Exception $e) { $this->_exit($e); }
			}
		}
		catch(Exception $e) { $this->_exit($e); return; }

		$viewData['zone'] = $zone;
		$viewData['intAddrs'] = $intAddrs;
		$viewData['za'] = $za;

		$this->load->view('dns/zonea/modify',$viewData);
	}
}
/* End of file zonea.php */
/* Location: ./application/controllers/dns/zonea.php */
