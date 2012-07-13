<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Search extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Search");
		$this->_addTrail("Search","#");
	}

	public function index() {
		if($this->input->post()) {
			try {
				$query = $this->api->search($this->input->post());
			}
			catch(Exception $e) { $this->_exit($e); return; }
			$results[] = array("Datacenter","Availability Zone","System Name","MAC","Address","System Owner","System Last Modifier","Range","Hostname","Zone","DNS Owner","DNS Last Modifier");
			foreach($query->result_array() as $result) {
				$datacenter = $result['datacenter'];
				$result['datacenter'] = "<a href=\"/datacenter/view/".rawurlencode($result['datacenter'])."\">{$result['datacenter']}</a>";
				$result['availability_zone'] = "<a href=\"/availabilityzone/view/".rawurlencode($datacenter)."/".rawurlencode($result['availability_zone'])."\">{$result['availability_zone']}</a>";
				$result['system_name'] = "<a href=\"/system/view/".rawurlencode($result['system_name'])."\">{$result['system_name']}</a>";
				$result['mac'] = "<a href=\"/interface/view/".rawurlencode($result['mac'])."\">{$result['mac']}</a>";
				$result['hostname'] = "<a href=\"/dns/view/".rawurlencode($result['address'])."\">{$result['hostname']}</a>";
				$result['address'] = "<a href=\"/address/view/".rawurlencode($result['address'])."\">{$result['address']}</a>";
				$result['zone'] = "<a href=\"/dns/zone/view/".rawurlencode($result['zone'])."\">{$result['zone']}</a>";
				$result['range'] = "<a href=\"/ip/range/view/".rawurlencode($result['range'])."\">{$result['range']}</a>";
				$results[] = $result;
			}
			$systemData = $this->table->generate($results);
			$this->_render($systemData);
			return;
		}
		
		// Data
		try {
			$rs = $this->api->ip->get->ranges();
		}
		catch(ObjectNotFoundException $e) { $rs = array(); }
		catch(Exception $e) { $this->_exit($e); return; }
		try {
			$snets = $this->api->ip->get->subnets();
		}
		catch(ObjectNotFoundException $e) { $snets = array(); }
		catch(Exception $e) { $this->_exit($e); return; }
		try {
			$dcs = $this->api->systems->get->datacenters();
		}
		catch(ObjectNotFoundException $e) { $dcs = array(); }
		catch(Exception $e) { $this->_exit($e); return; }
		try {
			$zs = $this->api->dns->get->zonesByUser(null);
		}
		catch(ObjectNotFoundException $e) { $zs = array(); }
		catch(Exception $e) { $this->_exit($e); return; }
		$azs = array();
		foreach($dcs as $dc) {
			try {
				$azs = array_merge($azs, $this->api->systems->get->availabilityzonesByDatacenter($dc->get_datacenter()));
			}
			catch(ObjectNotFoundException $e) {}
			catch(Exception $e) { $this->_exit($e); return; }
		}

		// Viewdata
		$viewData['rs'] = $rs;
		$viewData['snets'] = $snets;
		$viewData['dcs'] = $dcs; 
		$viewData['azs'] = $azs;
		$viewData['zs'] = $zs;

		// Content
		$content = $this->load->view('search/form',$viewData,true);

		// Render
		$this->_render($content);
	}
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
