<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Cname extends DnsController {

	public function view($zone,$alias) {
		// Decode
		$zone = rawurldecode($zone);
		$alias = rawurldecode($alias);

		// Instantiate
		try {
			$cRec = $this->api->dns->get->cname($zone, $alias);
		}
		catch (Exception $e) { $this->_error($e); return; }

		$this->load->view('dns/cname/detail',array('rec'=>$cRec));
	}

	public function create($address=null) {
		$address = rawurldecode($address);
		if($this->input->post()) {
			$ttl = $this->_postToNull('ttl');
			try {
				$aRec = $this->api->dns->get->address($this->input->post('zone'),$this->input->post('address'));
				$cRec = $this->api->dns->create->cname(
					$this->input->post('alias'),
					$aRec->get_hostname(),
					$this->input->post('zone'),
					$ttl,
					$this->input->post('owner')
				);
				$this->_sendClient("/dns/records/view/".rawurlencode($cRec->get_address()));
			}
			catch (Exception $e) { $this->_error($e); return; }
		}
		else {
			try {
				$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			}
			catch (Exception $e) { $this->_error($e); return; }
			$content = $this->load->view('dns/cname/create',array('zones'=>$zones,'user'=>$this->user,'address'=>$address),true);

			$this->_renderSimple($content);
		}
	}

	public function modify($zone, $alias) {
		// Decode
		$zone = rawurldecode($zone);
		$alias = rawurldecode($alias);

		if($this->input->post()) {
			try {
				$cRec = $this->api->dns->get->cname($zone, $alias);
			}
			catch (Exception $e) { $this->_error($e); return; }

			$err = array();

			if($cRec->get_alias() != $this->input->post('alias')) {
				try { $cRec->set_alias($this->input->post('alias')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($cRec->get_hostname() != $this->input->post('hostname')) {
				try { $cRec->set_hostname($this->input->post('hostname')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($cRec->get_zone() != $this->input->post('zone')) {
				try { $cRec->get_zone($this->input->post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($cRec->get_ttl() != $this->input->post('ttl')) {
				try { $cRec->set_ttl($this->input->post('ttl')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($cRec->get_owner() != $this->input->post('owner')) {
				try { $cRec->set_owner($this->input->post('owner')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
				return;
			}

			$this->_sendClient("/dns/records/view/".rawurlencode($cRec->get_address()));
			return;
		}
		else {

		// Instantiate
		$aRecs= array();
		try {
			$cRec = $this->api->dns->get->cname($zone, $alias);
			$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			foreach($systems as $sys) {
				try {
					$aRecs= array_merge($aRecs, $this->api->dns->get->addressesBySystem($sys->get_system_name()));
				}
				catch (ObjectNotFoundException $e) { continue; }
				catch (Exception $e) { $this->_error($e); return; }
			}
		}
		catch (Exception $e) { $this->_error($e); return; }

		// View Data
		$viewData['cRec'] = $cRec;
		$viewData['zones'] = $zones;
		$viewData['aRecs'] = $aRecs;
		$viewData['user'] = $this->user;

		// Content
		$content = $this->load->view('dns/cname/modify',$viewData,true);

		// Render
		$this->_renderSimple($content);
		}
	}

	public function remove($zone,$alias) {
		// Decode
		$zone = rawurldecode($zone);
		$alias = rawurldecode($alias);


		if(!$this->input->post('confirm')) {
			$this->_error(new Exception("No confirmation!"));
			return;
		}

		try {
			$cRec = $this->api->dns->get->cname($zone,$alias);
			$this->api->dns->remove->cname($alias,$zone);
			$this->_sendClient("/dns/records/view/".rawurlencode($cRec->get_address()));
		}
		catch (Exception $e) { $this->_error($e); }
	}
}
/* End of file cname.php */
/* Location: ./application/controllers/dns/cname.php */
