<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Srv extends DnsController {

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

	public function create($address=null) {
		// Decode
		$address = rawurldecode($address);

		if($this->input->post()) {
			$ttl = $this->_postToNull('ttl');
			try {
				$aRec = $this->api->dns->get->address($this->_post('zone'),$this->_post('address'));
				$sRec = $this->api->dns->create->srv(
					$this->_post('alias'),
					$aRec->get_hostname(),
					$this->_post('zone'),
					$this->_post('priority'),
					$this->_post('weight'),
					$this->_post('port'),
					$ttl,
					$this->_post('owner')
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
			$content = $this->load->view('dns/srv/create',array('zones'=>$zones,'user'=>$this->user,'address'=>$address),true);

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

			if($sRec->get_alias() != $this->_post('alias')) {
				try { $sRec->set_alias($this->_post('alias')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_hostname() != $this->_post('hostname')) {
				try { $sRec->set_hostname($this->_post('hostname')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_zone() != $this->_post('zone')) {
				try { $sRec->get_zone($this->_post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_ttl() != $this->_post('ttl')) {
				try { $sRec->set_ttl($this->_post('ttl')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_owner() != $this->_post('owner')) {
				try { $sRec->set_owner($this->_post('owner')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_priority() != $this->_post('priority')) {
				try { $sRec->set_priority($this->_post('priority')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_weight() != $this->_post('weight')) {
				try { $sRec->set_weight($this->_post('weight')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($sRec->get_port() != $this->_post('port')) {
				try { $sRec->set_port($this->_post('port')); }
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
