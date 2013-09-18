<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Vlancontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Network");
		$this->_setSubHeader("VLANs");
		$this->_addTrail("Network","/network");
		$this->_addTrail("VLANs","/network/vlans");
	}

	public function index() {
		$this->_sendClient("/network/vlans/view/");
	}

	public function view($datacenter,$vlan) {
		// Decode
		$datacenter = rawurldecode($datacenter);
		$vlan = rawurldecode($vlan);

		// Instantiate
		try {
			$v = $this->api->network->get->vlan($datacenter, $vlan);
			$vlans = $this->api->network->get->vlans($v->get_datacenter());
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($v->get_datacenter(),"/datacenter/view/".rawurlencode($v->get_datacenter()));
		$this->_addTrail($v->get_vlan(),"/network/vlan/view/".rawurlencode($v->get_datacenter())."/".rawurlencode($v->get_vlan()));

		// Actions
		$this->_addAction("Modify","/network/vlan/modify/".rawurlencode($v->get_datacenter())."/".rawurlencode($v->get_vlan()));
		$this->_addAction("Remove","/network/vlan/remove/".rawurlencode($v->get_datacenter())."/".rawurlencode($v->get_vlan()));

		// Sidebar
		$this->_addSidebarHeader("VLANs");
		foreach($vlans as $vla) {
			if($vla->get_vlan() == $v->get_vlan()) {
				$this->_addSidebarItem($vla->get_vlan()." (".$vla->get_name().")","/network/vlan/view/".rawurlencode($vla->get_datacenter())."/".rawurlencode($vla->get_vlan()),"signal",1);
			} else {
				$this->_addSidebarItem($vla->get_vlan()." (".$vla->get_name().")","/network/vlan/view/".rawurlencode($vla->get_datacenter())."/".rawurlencode($vla->get_vlan()),"signal");
			}
		}

		try {
			$snets = $this->api->ip->get->subnetsByVlan($v->get_datacenter(), $v->get_vlan());
		}
		catch(ObjectNotFoundException $e) { $snets = array(); }
		catch(Exception $e) { $this->_exit($e); return; }
		

		// Viewdata
		$viewData['v'] = $v;
        $viewData['snets'] = $snets;

		// Content
		$content = $this->load->view('vlan/detail',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function create($datacenter) {
		// Decode
		$datacenter = rawurldecode($datacenter);

		// Instantiate
		try {
			$dc = $this->api->systems->get->datacenterByName($datacenter);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			try {
				$v = $this->api->network->create->vlan(
					$dc->get_datacenter(),
					$this->_post('vlan'),
					$this->_post('name'),
					$this->_post('comment')
				);
				$this->_sendClient("/network/vlan/view/".rawurlencode($v->get_datacenter())."/".rawurlencode($v->get_vlan()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		// Trail
		$this->_addTrail($dc->get_datacenter(),"/datacenter/view/".rawurlencode($dc->get_datacenter()));

		$content = $this->load->view('vlan/create',null,true);
		$content .= $this->forminfo;

		$this->_render($content);
	}

	public function modify($datacenter, $vlan) {
		// Decode
		$datacenter = rawurldecode($datacenter);
		$vlan = rawurldecode($vlan);

		// Instantiate
		try {
			$v = $this->api->network->get->vlan($datacenter, $vlan);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();

			if($v->get_datacenter() != $this->_post('datacenter')) {
				try { $v->set_datacenter($this->_post('datacenter')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($v->get_vlan() != $this->_post('vlan')) {
				try { $v->set_vlan($this->_post('vlan')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($v->get_name() != $this->_post('name')) {
				try { $v->set_name($this->_post('name')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($v->get_comment() != $this->_post('comment')) {
				try { $v->set_comment($this->_post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err); 
				return;
			}

			$this->_sendClient("/network/vlan/view/".rawurlencode($v->get_datacenter())."/".rawurlencode($v->get_vlan()));
			return;
		}

		$viewData['dcs'] = $this->api->systems->get->datacenters();
		$viewData['v'] = $v;

		$content = $this->load->view('vlan/modify',$viewData,true);
		$content .= $this->forminfo;

		$this->_render($content);

	}

	public function remove($datacenter, $vlan) {
		// Decode
		$datacenter = rawurldecode($datacenter);
		$vlan = rawurldecode($vlan);

		// Instantiate
		try {
			$v = $this->api->network->get->vlan($datacenter, $vlan);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->network->remove->vlan($v->get_datacenter(),$v->get_vlan());
				$this->_sendClient("/datacenter/view/".rawurlencode($v->get_datacenter()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		} else {
			$this->_error(new Exception("No confirmation"));
		}
	}
}

/* End of file vlancontroller.php */
/* Location: ./application/controllers/network/vlancontroller.php */
