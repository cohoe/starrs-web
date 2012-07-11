<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Datacentercontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->_sendClient("/datacenters/view/");
	}

	public function view($datacenter) {
		// Decode
		$datacenter = rawurldecode($datacenter);

		// Instantiate
		try {
			$dc = $this->api->systems->get->datacenterByName($datacenter);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		$this->_addSidebarHeader("AVAILABILITY ZONES");

		$this->_addAction("Create Availability Zone","/availabilityzone/create/".rawurlencode($dc->get_datacenter()),"success");
		$this->_addAction("Modify","/datacenter/modify/".rawurlencode($dc->get_datacenter()));
		$this->_addAction("Remove","/datacenter/create/".rawurlencode($dc->get_datacenter()));

		try {
			$azs = $this->api->systems->get->availabilityzonesByDatacenter($dc->get_datacenter());
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_exit($e); return; }

		$azData = "";
		foreach($azs as $az) {
			$this->_addSidebarItem($az->get_zone(),"/availabilityzone/view/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone()));
			#$this->_addContentToList($this->load->view('availabilityzone/detail',array("az"=>$az),true),3);
			$azData .= $this->load->view('availabilityzone/detail',array("az"=>$az),true);
		}

		#$viewData['azdata'] = $azData; #$this->_renderContentList(3);
		$viewData['azs'] = $azs;
		$viewData['dc'] = $dc;
		$content = $this->load->view('datacenter/overview.php',$viewData,true);

		$this->_render($content);
	}
}

/* End of file datacentercontroller.php */
/* Location: ./application/controllers/datacentercontroller.php */
