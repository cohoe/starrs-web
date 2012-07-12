<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Datacentercontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_addTrail("Datacenters","/datacenters");
		$this->_addScript("/js/systems.js");
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

		// Actions
		$this->_addAction("Create Availability Zone","/availabilityzone/create/".rawurlencode($dc->get_datacenter()),"success");
		$this->_addAction("Modify","/datacenter/modify/".rawurlencode($dc->get_datacenter()));
		$this->_addAction("Remove","/datacenter/remove/".rawurlencode($dc->get_datacenter()));

		try {
			$azs = $this->api->systems->get->availabilityzonesByDatacenter($dc->get_datacenter());
		}
		catch(ObjectNotFoundException $e) { $azs = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Sidebar
		$this->_addSidebarHeader("AVAILABILITY ZONES","/availabilityzones/view");
		foreach($azs as $az) {
			$this->_addSidebarItem($az->get_zone(),"/availabilityzone/view/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone()),"folder-open");
		}
		$this->_addSidebarHeader("SUBNETS");
		try {
			$snets = $this->api->ip->get->subnets(null);
		}
		catch(ObjectNotFoundException $e) { $snets = array(); }
		catch(Exception $e) { $this->_exit($e); return; }
		foreach($snets as $snet) {
			if($snet->get_datacenter() == $dc->get_datacenter()) {
				$this->_addSidebarItem($snet->get_subnet(),"/ip/subnet/view/".rawurlencode($snet->get_subnet()),"tags");
			}
		}
		$this->_addSidebarHeader("SYSTEMS");
		try {
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
		}
		catch(ObjectNotFoundException $e) { $systems = array(); }
		catch(Exception $e) { $this->_exit($e); return; }
		foreach($systems as $sys) {
			if($sys->get_datacenter() == $dc->get_datacenter()) {
				$this->_addSidebarItem($sys->get_system_name(),"/system/view/".rawurlencode($sys->get_system_name()),"hdd");
			}
		}

		// Trail
		$this->_addTrail($dc->get_datacenter(),"/datacenter/view/".rawurlencode($dc->get_datacenter()));

		// Viewdata
		$viewData['azs'] = $azs;
		$viewData['dc'] = $dc;

		// Content
		$content = $this->load->view('datacenter/overview.php',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function create() {
		// Create
		if($this->input->post()) {
			try {
				$dc = $this->api->systems->create->datacenter($this->_post('name'),$this->_post('comment'));
			}
			catch(Exception $e) { $this->_error($e); return; }
			$this->_sendClient("/datacenter/view/".rawurlencode($dc->get_datacenter()));
		}
		
		$content = $this->load->view('datacenter/create',null,true);
		$content .= $this->forminfo;
		$this->_render($content);
	}

	public function modify($datacenter) {
		// Decode
		$datacenter = rawurldecode($datacenter);

		// Instantiate
		try {
			$dc = $this->api->systems->get->datacenterByName($datacenter);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($dc->get_datacenter(),"/datacenter/view/".rawurlencode($dc->get_datacenter()));

		// Modify
		if($this->input->post()) {
			$err = array();

			if($dc->get_datacenter() != $this->input->post('name')) {
				try { $dc->set_datacenter($this->input->post('name')); }
				catch(Exception $e) { $err[] = $e; }
			}
			if($dc->get_comment() != $this->input->post('comment')) {
				try { $dc->set_comment($this->input->post('comment')); }
				catch(Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err); return;
			}

			$this->_sendClient("/datacenter/view/".rawurlencode($dc->get_datacenter()));
		}

		$viewData['dc'] = $dc;
		$content = $this->load->view('datacenter/modify',$viewData,true);

		// Content
		$this->_render($content);
	}

	public function remove($datacenter) {
		// Decode
		$datacenter = rawurldecode($datacenter);

		// Instantiate
		try {
			$dc = $this->api->systems->get->datacenterByName($datacenter);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Remove
		if($this->input->post('confirm')) {
			try {
				$this->api->systems->remove->datacenter($dc->get_datacenter());
				$this->_sendClient("/datacenters/view");
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("No confirmation"));
		}
	}
}

/* End of file datacentercontroller.php */
/* Location: ./application/controllers/datacentercontroller.php */
