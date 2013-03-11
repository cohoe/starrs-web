<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Mx extends DnsController {

	public function view($zone,$preference) {
		// Decode
		$zone = rawurldecode($zone);
		$preference = rawurldecode($preference);

		// Instantiate
		try {
			$mRec = $this->api->dns->get->mx($zone, $preference);
		}
		catch (Exception $e) { $this->_error($e); return; }

		$this->load->view('dns/mx/detail',array('rec'=>$mRec));
	}

	public function create($address=null) {
		// Decode
		$address = rawurldecode($address);
		if($this->input->post()) {
			$ttl = $this->_postToNull('ttl');
			try {
				$aRec = $this->api->dns->get->address($this->_post('zone'),$this->_post('address'));
				$mRec = $this->api->dns->create->mx(
					$aRec->get_hostname(),
					$this->_post('zone'),
					$this->_post('preference'),
					$ttl,
					$this->_post('owner'));
				$this->_sendClient("/dns/records/view/".rawurlencode($mRec->get_address()));
			}
			catch (Exception $e) { $this->_error($e); return; }
		}
		else {
			try {
				$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			}
			catch (Exception $e) { $this->_error($e); return; }
			$content = $this->load->view('dns/mx/create',array('zones'=>$zones,'user'=>$this->user,'address'=>$address),true);

			$this->_renderSimple($content);
		}
	}

	public function modify($zone, $preference) {
		// Decode
		$zone = rawurldecode($zone);
		$preference = rawurldecode($preference);

		if($this->input->post()) {
			try {
				$mRec = $this->api->dns->get->mx($zone, $preference);
			}
			catch (Exception $e) { $this->_error($e); return; }

			$err = array();

			if($mRec->get_hostname() != $this->_post('hostname')) {
				try { $mRec->set_hostname($this->_post('hostname')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($mRec->get_zone() != $this->_post('zone')) {
				try { $mRec->get_zone($this->_post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($mRec->get_ttl() != $this->_post('ttl')) {
				try { $mRec->set_ttl($this->_post('ttl')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($mRec->get_owner() != $this->_post('owner')) {
				try { $mRec->set_owner($this->_post('owner')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($mRec->get_preference() != $this->_post('preference')) {
				try { $mRec->set_preference($this->_post('preference')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
				return;
			}

			$this->_sendClient("/dns/records/view/".rawurlencode($mRec->get_address()));
			return;
		}
		else {

		// Instantiate
		$aRecs = array();
		try {
			$mRec = $this->api->dns->get->mx($zone, $preference);
			$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			$systems[] = $this->api->systems->get->systemByAddress($mRec->get_address());
			foreach($systems as $sys) {
				try {
					$aRecs = array_merge($aRecs, $this->api->dns->get->addressesBySystem($sys->get_system_name()));
				}
				catch (ObjectNotFoundException $e) { continue; }
				catch (Exception $e) { $this->_error($e); return; }
			}
		}
		catch (Exception $e) { $this->_error($e); return; }

		// View Data
		$viewData['mRec'] = $mRec;
		$viewData['zones'] = $zones;
		$viewData['aRecs'] = $aRecs;
		$viewData['user'] = $this->user;

		// Content
		$content = $this->load->view('dns/mx/modify',$viewData,true);

		// Render
		$this->_renderSimple($content);
		}
	}

	public function remove($zone,$preference) {
		// Decode
		$zone = rawurldecode($zone);
		$preference = rawurldecode($preference);

		if(!$this->input->post('confirm')) {
			$this->_error(new Exception("No confirmation!"));
			return;
		}

		try {
			$mRec = $this->api->dns->get->mx($zone, $preference);
			$this->api->dns->remove->mx($zone,$preference);
			$this->_sendClient("/dns/records/view/".rawurlencode($mRec->get_address()));
		}
		catch (Exception $e) { $this->_error($e); }
	}
}
/* End of file mx.php */
/* Location: ./application/controllers/dns/mx.php */
