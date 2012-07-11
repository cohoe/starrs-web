<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Availabilityzonecontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_addTrail("Datacenters","/datacenters");
		$this->_addScript("/js/systems.js");
	}

	public function index() {
		$this->_sendClient("/datacenters/view/");
	}

	public function view($datacenter, $zone) {
		// Decode
		$datacenter = rawurldecode($datacenter);
		$zone= rawurldecode($zone);

		// Instantiate
		try {
			#$dc = $this->api->systems->get->datacenterByName($datacenter);
			$az = $this->api->systems->get->availabilityzone($datacenter, $zone);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Sidebar
		$this->_addSidebarHeader("IP RANGES");

		// Actions
		$this->_addAction("Modify","/availabilityzone/modify/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone()));
		$this->_addAction("Remove","/availabilityzone/remove/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone()));

		// Trail
		$this->_addTrail($az->get_datacenter(),"/datacenter/view/".rawurlencode($az->get_datacenter()));
		$this->_addTrail("Availability Zones","/availabilityzones/view");
		$this->_addTrail($az->get_zone(),"/availabilityzone/view/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone()));

		// Viewdata
		$viewData['az'] = $az;

		// Content
		$content = $this->load->view('availabilityzone/detail.php',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function create($datacenter) {
		// Decode
		$datacenter = rawurldecode($datacenter);

		if($this->input->post()) {
			try {
				$az = $this->api->systems->create->availabilityzone(
					$this->_post('datacenter'),
					$this->_post('zone'),
					$this->_post('comment')
				);
				$this->_sendClient("/availabilityzone/view/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		
		// Instantiate
		try {
			$dc = $this->api->systems->get->datacenterByName($datacenter);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($dc->get_datacenter(),"/datacenter/view/".rawurlencode($dc->get_datacenter()));
		$this->_addTrail("Availability Zones","/datacenter/view/".rawurlencode($dc->get_datacenter()));

		// Viewdata
		$viewData['dc'] = $dc;

		// Content
		$content = $this->load->view('availabilityzone/create',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function modify($datacenter, $zone) {
		// Decode
		$datacenter = rawurldecode($datacenter);
		$zone = rawurldecode($zone);

		// Instantiate
		try {
			$az = $this->api->systems->get->availabilityzone($datacenter, $zone);
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post()) {
			$err = array();

			if($az->get_datacenter() != $this->input->post('datacenter')) {
				try { $az->set_datacenter($this->_post('datacenter')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($az->get_zone() != $this->input->post('zone')) {
				try { $az->set_zone($this->_post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($az->get_comment() != $this->input->post('comment')) {
				try { $az->set_comment($this->_post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
				return;
			}

			$this->_sendClient("/availabilityzone/view/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone()));
			return;
		}

		// Viewdata
		try {
			$viewData['dcs'] = $this->api->systems->get->datacenters();
		}
		catch(Exception $e) { $this->_error($e); return; }
		$viewData['az'] = $az;

		// Content
		$content = $this->load->view('availabilityzone/modify',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function remove($datacenter, $zone) {
		// Decode
		$datacenter = rawurldecode($datacenter);
		$zone = rawurldecode($zone);

		// Instantiate
		try {
			$az = $this->api->systems->get->availabilityzone($datacenter, $zone);
		}
		catch(Exception $e) { $this->_error($e); return; }

		// Remove
		if($this->input->post('confirm')) {
			try {
				$this->api->systems->remove->availabilityzone($az->get_datacenter(), $az->get_zone());
				$this->_sendClient("/datacenter/view/".rawurlencode($az->get_datacenter()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("No confirmation"));
			return;
		}
	}
}

/* End of file availabilityzonecontroller.php */
/* Location: ./application/controllers/availabilityzonecontroller.php */
