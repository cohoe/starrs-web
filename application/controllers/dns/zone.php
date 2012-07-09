<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Zone extends DnsController {

	public function __construct() {
		parent::__construct();
		$this->_addScript("/js/dns.js");
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
			$this->_addTrail("DNS","/dns");
			$this->_addTrail("Zones","/dns/zones");
			$this->_addTrail($z->get_zone(),"/dns/zone/view/".rawurlencode($z->get_zone()));

			// Sidebar
			$this->_addSidebarItem("Zone","#zone","list");
			$this->_addSidebarItem("SOA","#soa","cog");
			$this->_addSidebarItem("NS Records","#ns","file");
			$this->_addSidebarItem("A/AAAA Records","#a","font");
			$this->_addSidebarItem("TXT Records","#txt","list-alt");

			// Actions
			$this->_addAction("Create NS","/dns/ns/create/","success");
			$this->_addAction("Create A/AAAA","#","success");
			$this->_addAction("Create TXT","#","success");
			$this->_addAction("Modify","#");
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
				$z = $this->api->dns->create->zone(
					$this->input->post('zone'),
					$this->input->post('key'),
					$this->input->post('forward'),
					$this->input->post('shared'),
					$this->input->post('comment'),
					$this->input->post('owner')
				);
				$this->_sendClient("/dns/zone/view/".rawurlencode($z->get_zone()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		try {
			$viewData['keys'] = $this->api->dns->get->keysByUser($this->user->getActiveUser());
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_error($e); return; }
		$viewData['owner'] = $this->user->getActiveUser();
		$viewData['isAdmin'] = $this->user->isAdmin();
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
}
/* End of file zone.php */
/* Location: ./application/controllers/dns/zone.php */
