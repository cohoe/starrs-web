<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Ns extends DnsController {

	public function view($zone,$nameserver) {
		// Decode
		$zone = rawurldecode($zone);
		$nameserver = rawurldecode($nameserver);

		// Instantiate
		try {
			$nRec = $this->api->dns->get->ns($zone, $nameserver);
		}
		catch (Exception $e) { $this->_error($e); return; }

		$this->load->view('dns/ns/detail',array('rec'=>$nRec));
	}

	public function create($address=null) {
		// Decode
		if(isset($address)) {
			$address = rawurldecode($address);
		}


		if($this->input->post()) {
			$ttl = $this->_postToNull('ttl');
			try {
				$nRec = $this->api->dns->create->ns(
					$this->input->post('zone'),
					$this->input->post('nameserver'),
					$this->input->post('address'),
					$ttl);
				$this->_sendClient("/dns/records/view/".rawurlencode($nRec->get_address()));
			}
			catch (Exception $e) { $this->_error($e); return; }
		}
		else {
			try {
				$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			}
			catch (Exception $e) { $this->_error($e); return; }
			$content = $this->load->view('dns/ns/create',array('zones'=>$zones,'user'=>$this->user,'address'=>$address),true);

			$this->_renderSimple($content);
		}
	}

	public function modify($zone, $nameserver) {
		// Decode
		$zone = rawurldecode($zone);
		$nameserver = rawurldecode($nameserver);

		if($this->input->post()) {
			try {
				$nRec = $this->api->dns->get->ns($zone, $nameserver);
			}	
			catch (Exception $e) { $this->_error($e); return; }

			$err = array();

			if($nRec->get_zone() != $this->input->post('zone')) {
				try { $nRec->get_zone($this->input->post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($nRec->get_ttl() != $this->input->post('ttl')) {
				try { $nRec->set_ttl($this->input->post('ttl')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($nRec->get_nameserver() != $this->input->post('nameserver')) {
				try { $nRec->set_nameserver($this->input->post('nameserver')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($nRec->get_address() != $this->input->post('address')) {
				try { $nRec->set_address($this->input->post('address')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
				return;
			}

			$this->_sendClient("/dns/records/view/".rawurlencode($nRec->get_address()));
			return;
		}
		else {

			// Instantiate
			try {
				$nRec = $this->api->dns->get->ns($zone, $nameserver);
				$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			}
			catch (Exception $e) { $this->_error($e); return; }

			// View Data
			$viewData['nRec'] = $nRec;
			$viewData['zones'] = $zones;
			$viewData['user'] = $this->user;

			// Content
			$content = $this->load->view('dns/ns/modify',$viewData,true);

			// Render
			$this->_renderSimple($content);
		}
	}

	public function remove($zone,$nameserver) {
		// Decode
		$zone = rawurldecode($zone);
		$nameserver = rawurldecode($nameserver);

		if(!$this->input->post('confirm')) {
			$this->_error(new Exception("No confirmation!"));
			return;
		}

		try {
			$nRec = $this->api->dns->get->ns($zone, $nameserver);
			$this->api->dns->remove->ns($zone,$nameserver);
			$this->_sendClient("/dns/records/view/".rawurlencode($nRec->get_address()));
		}
		catch (Exception $e) { $this->_error($e); }
	}
}
/* End of file ns.php */
/* Location: ./application/controllers/dns/ns.php */
