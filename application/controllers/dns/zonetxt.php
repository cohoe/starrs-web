<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Zonetxt extends DnsController {

	public function __construct() {
		parent::__construct();
		#$this->_addScript("/js/dns.js");
	}

	public function create($zone=null) {
		// Decode
		$zone = rawurldecode($zone);

		if($this->input->post()) {
			try {
				$zt = $this->api->dns->create->zonetxt(
					$this->_postToNull('hostname'),
					$this->input->post('zone'),
					$this->input->post('text'),
					$this->_postToNull('ttl')
				);

				$this->_sendClient("/dns/zone/view/".rawurlencode($zt->get_zone()));
			}
			catch (Exception $e) { $this->_error($e); return; }
		}

		$viewData['zone'] = $zone;

		$this->load->view('dns/zonetxt/create',$viewData);
	}

	public function view($zone=null,$hash=null) {
		// Decode
		$zone = rawurldecode($zone);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$zt = $this->api->dns->get->zonetxtByZoneHash($zone,$hash);
			$this->load->view('dns/zonetxt/detail',array('rec'=>$zt));
		}
		catch(Exception $e) { $this->_error($e); return; }
	}

	public function remove($zone=null,$hash=null) {
		// Decode
		$zone = rawurldecode($zone);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$zt = $this->api->dns->get->zonetxtByZoneHash($zone,$hash);
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->dns->remove->zonetxt($zt->get_hostname(), $zt->get_zone(),$zt->get_text());
				$this->_sendClient("/dns/zone/view/".rawurlencode($zt->get_zone()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("no confirmation")); return;
		}
	}

	public function modify($zone,$hash) {
		// Decode
		$zone = rawurldecode($zone);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$zt = $this->api->dns->get->zonetxtByZoneHash($zone,$hash);
		}
		catch(Exception $e) { $this->_error($e); return; }
		
		if($this->input->post()) {
			$err = array();

			if($zt->get_ttl() != $this->input->post('ttl')) {
				try { $zt->set_ttl($this->input->post('ttl')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($zt->get_text() != $this->input->post('text')) {
				try { $zt->set_text($this->input->post('text')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($zt->get_zone() != $this->input->post('zone')) {
				try { $zt->set_zone($this->input->post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($zt->get_hostname() != $this->input->post('hostname')) {
				try { $zt->set_hostname($this->_postToNull('hostname')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err); return;
			}

			$this->_sendClient("/dns/zone/view/".rawurlencode($zt->get_zone()));
			return;
		}

		$viewData['zt'] = $zt;

		$this->load->view('dns/zonetxt/modify',$viewData);
	}
}
/* End of file zonetxt.php */
/* Location: ./application/controllers/dns/zonetxt.php */
