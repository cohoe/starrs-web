<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Aaaa extends DnsController {

	public function view($zone,$address) {
		// Decode
		$zone = rawurldecode($zone);
		$address = rawurldecode($address);

		// Instantiate
		try {
			$aRec = $this->api->dns->get->address($zone, $address);
		}
		catch (Exception $e) { $this->_error($e); return; }

		$this->load->view('dns/a/detail',array('rec'=>$aRec));
	}

	public function create($address) {
		// Decode
		$address = rawurldecode($address);

		if($this->input->post()) {
			$ttl = $this->_postToNull('ttl');
			try {
				$aRec = $this->api->dns->create->address(
					$address,
					$this->_post('hostname'),
					$this->_post('zone'),
					$ttl,
					'AAAA',
					$this->_post('reverse'),
					$this->_post('owner'));
				$this->_sendClient("/dns/records/view/".rawurlencode($aRec->get_address()));
			}
			catch (Exception $e) { $this->_error($e); return; }
		}
		else {
			try {
				$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			}
			catch (Exception $e) { $this->_error($e); return; }
			$content = $this->load->view('dns/a/create',array('zones'=>$zones,'user'=>$this->user),true);

			$this->_renderSimple($content);
		}
	}

	public function modify($zone, $address) {
		// Decode
		$zone = rawurldecode($zone);
		$address = rawurldecode($address);

		if($this->input->post()) {
			try {
				$aRec = $this->api->dns->get->address($zone, $address);
			}
			catch (Exception $e) { $this->_error($e); return; }

			$err = array();

			if($aRec->get_hostname() != $this->_post('hostname')) {
				try { $aRec->set_hostname($this->_post('hostname')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($aRec->get_zone() != $this->_post('zone')) {
				try { $aRec->get_zone($this->_post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($aRec->get_ttl() != $this->_post('ttl')) {
				try { $aRec->set_ttl($this->_post('ttl')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($aRec->get_owner() != $this->_post('owner')) {
				try { $aRec->set_owner($this->_post('owner')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($aRec->get_address() != $this->_post('address')) {
				try { $aRec->set_address($this->_post('address')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
				return;
			}

			$this->_sendClient("/dns/records/view/".rawurlencode($aRec->get_address()));
			return;
		}
		else {

		// Instantiate
		$intAddrs = array();
		$intAddrs[] = $this->api->systems->get->interfaceaddressByAddress($address);
		try {
			$aRec = $this->api->dns->get->address($zone, $address);
			$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			foreach($systems as $sys) {
				try {
					$intAddrs = array_merge($intAddrs, $this->api->systems->get->interfaceaddressesBySystem($sys->get_system_name()));
				}
				catch (ObjectNotFoundException $e) { continue; }
				catch (Exception $e) { $this->_error($e); return; }
			}
		}
		catch (Exception $e) { $this->_error($e); return; }

		// View Data
		$viewData['aRec'] = $aRec;
		$viewData['zones'] = $zones;
		$viewData['intAddrs'] = $intAddrs;
		$viewData['user'] = $this->user;

		// Content
		$content = $this->load->view('dns/a/modify',$viewData,true);

		// Render
		$this->_renderSimple($content);
		}
	}

	public function remove($zone,$address) {
		// Decode
		$zone = rawurldecode($zone);
		$address = rawurldecode($address);

		if(!$this->input->post('confirm')) {
			$this->_error(new Exception("No confirmation!"));
			return;
		}

		try {
			$this->api->dns->remove->address($address,$zone);
			$this->_sendClient("/dns/records/view/".rawurlencode($address));
		}
		catch (Exception $e) { $this->_error($e); }
	}
}
/* End of file aaaa.php */
/* Location: ./application/controllers/dns/aaaa.php */
