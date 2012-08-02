<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Zone extends DnsController {

	public function __construct() {
		parent::__construct();
		$this->_addScript("/js/dns.js");
		$this->_setSubHeader("Zones");
		$this->_addTrail("Zones","/dns/zones/");
	}

	public function index() {
		$this->_sendClient("/dns/zones");
	}

	public function view($zone=null) {
		// Decode
		$zone = rawurldecode($zone);

		try {
			// Get the zone info
			$z = $this->api->dns->get->zoneByName($zone);
			$zs = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			$zInfo = $this->load->view('dns/zone/detail',array('zone'=>$z),true);

			// A/AAAA Records
			try {
				$aRecs = $this->api->dns->get->zoneAddressesByZone($z->get_zone());
				$aRecInfo = $this->_renderDnsTable($aRecs, "Zone A/AAAA");
			}
			catch(ObjectNotFoundException $e) { $aRecInfo = $this->_renderDnsTable(array(),"Zone A/AAAA",1); }
			catch(Exception $e) { $this->_exit($e); return; }

			// NS Records
			try {
				$nRecs = $this->api->dns->get->nsByZone($z->get_zone());
				$nRecInfo = $this->_renderDnsTable($nRecs, "Zone NS");
			}
			catch(ObjectNotFoundException $e) { $nRecInfo = $this->_renderDnsTable(array(),"NS",1); }
			catch(Exception $e) { $this->_exit($e); return; }

			// TXT Records
			try {
				$tRecs = $this->api->dns->get->zoneTextsByZone($z->get_zone());
				$tRecInfo = $this->_renderDnsTable($tRecs, "Zone TXT");
			}
			catch(ObjectNotFoundException $e) { $tRecInfo = $this->_renderDnsTable(array(),"Zone TXT",1); }
			catch(Exception $e) { $this->_exit($e); return; }

			// View Data
			$viewData['zone'] = $z;
			$viewData['zoneInfo'] = $zInfo;
			$viewData['aRecInfo'] = $aRecInfo;
			$viewData['tRecInfo'] = $tRecInfo;
			$viewData['nRecInfo'] = $nRecInfo;

			// Breadcrumb
			$this->_addTrail($z->get_zone(),"/dns/zone/view/".rawurlencode($z->get_zone()));

			// Sidebar
			$this->_addSidebarHeader("ZONES");
			foreach($zs as $zne) {
				if($zne->get_zone() == $z->get_zone()) {
					$this->_addSidebarItem($zne->get_zone(),"/dns/zone/view/".rawurlencode($zne->get_zone()),"list",1);
				} else {
					$this->_addSidebarItem($zne->get_zone(),"/dns/zone/view/".rawurlencode($zne->get_zone()),"list");
				}
			}

			// Actions
			$this->_addAction("Create NS","/dns/ns/create/","success");
			$this->_addAction("Create Address","/dns/zonea/create/".rawurlencode($z->get_zone()),"success");
			$this->_addAction("Create TXT","/dns/zonetxt/create/".rawurlencode($z->get_zone()),"success");
			$this->_addAction("SOA","/dns/soa/view/".rawurlencode($z->get_zone()),"primary");
			$this->_addAction("Modify Zone","/dns/zone/modify/".rawurlencode($z->get_zone()),"warning");
			$this->_addAction("Remove","/dns/zone/remove/".rawurlencode($z->get_zone()));

			// Content
			$content = $this->load->view('dns/zone/overview',$viewData,true);
		}	
		catch(Exception $e) { $this->_exit($e); return; }

		// Render
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$z = $this->api->dns->create->zone(
					$this->_post('zone'),
					$this->_post('key'),
					$this->_post('forward'),
					$this->_post('shared'),
					$this->_post('owner'),
					$this->_post('comment'),
					$this->input->post('ddns')
				);
				$this->_sendClient("/dns/zone/view/".rawurlencode($z->get_zone()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		try {
			if($this->user->getActiveUser() == 'all') { $uname = null; } else { $uname = $this->user->getActiveUser(); }
			$viewData['keys'] = $this->api->dns->get->keysByUser($uname);
		}
		catch(ObjectNotFoundException $e) { $this->_exit(new Exception("No Keys configured! Setup at least one DNS key before attempting to create a zone.")); return; }
		catch(Exception $e) { $this->_error($e); return; }
		
		// View Data
		$viewData['user'] = $this->user;

		// Content
		$content = $this->load->view('dns/zone/create',$viewData,true);
		$this->_render($content);
	}

	public function remove($zone) {
		$zone = rawurldecode($zone);
		if($this->input->post('confirm')) {
			try {
				$this->api->dns->remove->zone($zone);
				$this->_sendClient("/dns/zones/view/");
			}
			catch(Exception $e) { $this->_error($e); }
		}
		else {
			$this->_error(new Exception("No confirmation"));
		}
	}

	public function modify($zone) {
		// Decode
		$zone = rawurldecode($zone);

		// Instantiate
		try {
			$z = $this->api->dns->get->zoneByName($zone);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();
			// Zone stuff
			if($z->get_zone() != $this->_post('zone')) {
				try { $z->set_zone($this->_post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_keyname() != $this->_post('keyname')) {
				try { $z->set_keyname($this->_post('keyname')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_forward() != $this->_post('forward')) {
				try { $z->set_forward($this->_post('forward')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_shared() != $this->_post('shared')) {
				try { $z->set_shared($this->_post('shared')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_ddns() != $this->input->post('ddns')) {
				try { $z->set_ddns($this->input->post('ddns')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_comment() != $this->_post('comment')) {
				try { $z->set_comment($this->_post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_owner() != $this->_post('owner')) {
				try { $z->set_owner($this->_post('owner')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($err) {
				$this->_error($err); return;
			}
			$this->_sendClient("/dns/zone/view/".rawurlencode($z->get_zone()));
		}

		try {
			if($this->user->getActiveUser() == 'all') { $uname = null; } else { $uname = $this->user->getActiveUser(); }
			$viewData['keys'] = $this->api->dns->get->keysByUser($uname);
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_error($e); return; }

		// View Data
		$viewData['isAdmin'] = $this->user->isAdmin();
		$viewData['z'] = $z;
		
		// Trail
		$this->_addTrail($z->get_zone(),"/dns/zone/view/".rawurlencode($z->get_zone()));

		// Content
		$content = $this->load->view('dns/zone/modify',$viewData,true);
		$content .= $this->forminfo;

		$this->_render($content);
	}
}
/* End of file zone.php */
/* Location: ./application/controllers/dns/zone.php */
