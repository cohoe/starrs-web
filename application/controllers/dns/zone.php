<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Zone extends DnsController {

	public function __construct() {
		parent::__construct();
		$this->_addScript("/js/dns.js");
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
			$zInfo = $this->load->view('dns/zone/detail',array('zone'=>$z),true);

			// SOA
			try {
				$soaRec = $this->api->dns->get->soa($z->get_zone());
				$soaInfo = $this->load->view('dns/soa/detail',array('soaRec'=>$soaRec),true);
			}
			catch(ObjectNotFoundException $e) { $soaInfo = "<div class=\"span6 well\"><a name=\"soa\"></a><h3>SOA</h3></div>"; }
			catch(Exception $e) { $this->_exit($e); return; }

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
			$viewData['soaInfo'] = $soaInfo;
			$viewData['aRecInfo'] = $aRecInfo;
			$viewData['tRecInfo'] = $tRecInfo;
			$viewData['nRecInfo'] = $nRecInfo;

			// Breadcrumb
			$this->_addTrail($z->get_zone(),"/dns/zone/view/".rawurlencode($z->get_zone()));

			// Sidebar
			$this->_addSidebarItem("Zone","#zone","list");
			$this->_addSidebarItem("SOA","#soa","cog");
			$this->_addSidebarItem("NS Records","#ns","file");
			$this->_addSidebarItem("A/AAAA Records","#a","font");
			$this->_addSidebarItem("TXT Records","#txt","list-alt");

			// Actions
			$this->_addAction("Create NS","/dns/ns/create/","success");
			$this->_addAction("Create Address","/dns/zonea/create/".rawurlencode($z->get_zone()),"success");
			$this->_addAction("Create TXT","/dns/zonetxt/create/".rawurlencode($z->get_zone()),"success");
			$this->_addAction("Modify Zone","/dns/zone/modify/".rawurlencode($z->get_zone()),"warning");
			$this->_addAction("Remove","/dns/zone/remove/".rawurlencode($z->get_zone()));

			// Content
			$content = $this->load->view('dns/zone/overview',$viewData,true);
			$content .= $this->load->view('dns/modalcreate',null,true);
			$content .= $this->load->view('dns/modalmodify',null,true);
			$content .= $this->load->view('core/modalconfirm',null,true);
		}	
		catch(Exception $e) { $this->_exit($e); return; }

		// Render
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$res = $this->api->dns->create->zone(
					$this->input->post('zone'),
					$this->input->post('key'),
					$this->input->post('forward'),
					$this->input->post('shared'),
					$this->input->post('owner'),
					$this->input->post('comment'),
					$this->input->post('nameserver'),
					$this->input->post('ttl'),
					$this->input->post('contact'),
					$this->input->post('serial'),
					$this->input->post('refresh'),
					$this->input->post('retry'),
					$this->input->post('expire'),
					$this->input->post('minimum')
				);
				$z = $res['zone'];
				$this->_sendClient("/dns/zone/view/".rawurlencode($z->get_zone()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		try {
			$viewData['keys'] = $this->api->dns->get->keysByUser($this->user->getActiveUser());
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_error($e); return; }
		
		// View Data
		$viewData['owner'] = $this->user->getActiveUser();
		$viewData['isAdmin'] = $this->user->isAdmin();

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
			$soa = $this->api->dns->get->soa($zone);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();
			// Zone stuff
			if($z->get_zone() != $this->input->post('zone')) {
				try { $z->set_zone($this->input->post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_keyname() != $this->input->post('keyname')) {
				try { $z->set_keyname($this->input->post('keyname')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_forward() != $this->input->post('forward')) {
				try { $z->set_forward($this->input->post('forward')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_shared() != $this->input->post('shared')) {
				try { $z->set_shared($this->input->post('shared')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_comment() != $this->input->post('comment')) {
				try { $z->set_comment($this->input->post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($z->get_owner() != $this->input->post('owner')) {
				try { $z->set_owner($this->input->post('owner')); }
				catch (Exception $e) { $err[] = $e; }
			}

			// SOA
			// Reinstantiate since the zone might have changed
			$soa = $this->api->dns->get->soa($z->get_zone());
			if($soa->get_nameserver() != $this->input->post('nameserver')) {
				try { $soa->set_nameserver($this->input->post('nameserver')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($soa->get_ttl() != $this->input->post('ttl')) {
				try { $soa->set_ttl($this->input->post('ttl')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($soa->get_contact() != $this->input->post('contact')) {
				try { $soa->set_contact($this->input->post('contact')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($soa->get_serial() != $this->input->post('serial')) {
				try { $soa->set_serial($this->input->post('serial')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($soa->get_refresh() != $this->input->post('refresh')) {
				try { $soa->set_refresh($this->input->post('refresh')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($soa->get_retry() != $this->input->post('retry')) {
				try { $soa->set_retry($this->input->post('retry')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($soa->get_expire() != $this->input->post('expire')) {
				try { $soa->set_expire($this->input->post('expire')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($soa->get_minimum() != $this->input->post('minimum')) {
				try { $soa->set_minimum($this->input->post('minimum')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err); return;
			}
			$this->_sendClient("/dns/zone/view/".rawurlencode($z->get_zone()));
		}

		try {
			$viewData['keys'] = $this->api->dns->get->keysByUser($this->user->getActiveUser());
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_error($e); return; }

		// View Data
		$viewData['isAdmin'] = $this->user->isAdmin();
		$viewData['z'] = $z;
		$viewData['soa'] = $soa;
		
		// Trail
		$this->_addTrail($z->get_zone(),"/dns/zone/view/".rawurlencode($z->get_zone()));

		// Content
		$content = $this->load->view('dns/zone/modify',$viewData,true);
		$content .= $this->load->view('core/forminfo',null,true);

		$this->_render($content);
	}
}
/* End of file zone.php */
/* Location: ./application/controllers/dns/zone.php */
