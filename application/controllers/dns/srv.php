<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Srv extends DnsController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DNS");
	}

	public function view($zone,$alias,$priority,$weight,$port) {
		// Decode
		$zone = rawurldecode($zone);
		$alias = rawurldecode($alias);
		$priority = rawurldecode($priority);
		$weight = rawurldecode($weight);
		$port = rawurldecode($port);

		// Instantiate
		try {
			$sRec = $this->api->dns->get->srv($zone, $alias, $priority, $weight, $port);
		}
		catch (Exception $e) { $this->_error($e); return; }

		$this->load->view('dns/srv/detail',array('rec'=>$sRec));
	}

	public function create() {
		if($this->input->post()) {
			$ttl = $this->_postToNull('ttl');
			try {
				$aRec = $this->api->dns->get->address($this->input->post('zone'),$this->input->post('address'));
				$sRec = $this->api->dns->create->srv(
					$this->input->post('alias'),
					$aRec->get_hostname(),
					$this->input->post('zone'),
					$this->input->post('priority'),
					$this->input->post('weight'),
					$this->input->post('port'),
					$ttl,
					$this->input->post('owner')
				);
				$this->_sendClient("/dns/records/view/".rawurlencode($sRec->get_address()));
			}
			catch (Exception $e) { $this->_error($e); return; }
		}
		else {
			try {
				$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			}
			catch (Exception $e) { $this->_error($e); return; }
			$content = $this->load->view('dns/srv/create',array('zones'=>$zones,'user'=>$this->user),true);

			$this->_renderSimple($content);
		}
	}

	public function modify($zone, $alias, $priority, $weight, $port) {
		// Decode
		$zone = rawurldecode($zone);
		$alias = rawurldecode($alias);
		$priority = rawurldecode($priority);
		$weight = rawurldecode($weight);
		$port = rawurldecode($port);

		if($this->input->post()) {
			try {
				$sRec = $this->api->dns->get->srv($zone, $alias, $priority, $weight, $port);
			}
			catch (Exception $e) { $this->_error($e); return; }

			$err = array();

			if($sRec->get_alias() != $this->input->post('alias')) {
				try { $sRec->set_alias($this->input->post('alias')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_hostname() != $this->input->post('hostname')) {
				try { $sRec->set_hostname($this->input->post('hostname')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_zone() != $this->input->post('zone')) {
				try { $sRec->get_zone($this->input->post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_ttl() != $this->input->post('ttl')) {
				try { $sRec->set_ttl($this->input->post('ttl')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_owner() != $this->input->post('owner')) {
				try { $sRec->set_owner($this->input->post('owner')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_priority() != $this->input->post('priority')) {
				try { $sRec->set_priority($this->input->post('priority')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_weight() != $this->input->post('weight')) {
				try { $sRec->set_weight($this->input->post('weight')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_port() != $this->input->post('port')) {
				try { $sRec->set_port($this->input->post('port')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
				return;
			}

			$this->_sendClient("/dns/records/view/".rawurlencode($sRec->get_address()));
			return;
		}
		else {
			// Instantiate
			$aRecs= array();
			try {
				$sRec = $this->api->dns->get->srv($zone, $alias, $priority, $weight, $port);
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
			$viewData['sRec'] = $sRec;
			$viewData['zones'] = $zones;
			$viewData['aRecs'] = $aRecs;
			$viewData['user'] = $this->user;

			// Content
			$content = $this->load->view('dns/srv/modify',$viewData,true);
	
			// Render
			$this->_renderSimple($content);
		}
	}

	public function remove($zone,$alias,$priority,$weight,$port) {
		// Decode
		$zone = rawurldecode($zone);
		$alias = rawurldecode($alias);
		$priority = rawurldecode($priority);
		$weight = rawurldecode($weight);
		$port = rawurldecode($port);


		if(!$this->input->post('confirm')) {
			$this->_error(new Exception("No confirmation!"));
			return;
		}

		try {
			$sRec = $this->api->dns->get->srv($zone,$alias,$priority,$weight,$port);
			$this->api->dns->remove->srv($alias,$zone,$priority,$weight,$port);
			$this->_sendClient("/dns/records/view/".rawurlencode($sRec->get_address()));
		}
		catch (Exception $e) { $this->_error($e); }
	}
}
/* End of file srv.php */
/* Location: ./application/controllers/dns/srv.php */
