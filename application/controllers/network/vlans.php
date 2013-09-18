<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Vlans extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Network");
		$this->_setSubHeader("VLANs");
		$this->_addTrail("Network","/network/");
		$this->_addTrail("VLANs","/network/vlans/view/");
	}

	public function index() {
		$this->_sendClient("/network/vlans/view/");
	}

	public function view($datacenter=null) {
		$datacenter = rawurldecode($datacenter);
		if($datacenter) {
			try {
				$vlans = $this->api->network->get->vlans($datacenter);
				foreach($vlans as $vlan) {
					print $vlan->get_vlan().":";
				}
			}
			catch(ObjectNotFoundException $e) {}
			catch(Exception $e) { $this->_exit($e); return; }
			return;
		}

		// Instantiate
		try {
			$dcs = $this->api->systems->get->datacenters();
			foreach($dcs as $dc) {
				$this->_addSidebarHeader($dc->get_datacenter(),"/datacenter/view/".rawurlencode($dc->get_datacenter()));
				try {
					$vlans = $this->api->network->get->vlans($dc->get_datacenter());
					foreach($vlans as $v) {
						$this->_addSidebarItem($v->get_vlan()." (".$v->get_name().")","/network/vlan/view/".rawurlencode($v->get_datacenter())."/".rawurlencode($v->get_vlan()),"signal");
					}
				}
				catch(ObjectNotFoundException $e) {}
				catch(Exception $e) { $this->_exit($e); return; }
			}
		}
		catch(ObjectNotFoundException $e) { $this->_sidebarBlank(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Content
		$content = $this->load->view('vlan/information',null,true);

		// Render
		$this->_render($content);
	}
}

/* End of file template.php */
/* Location: ./application/controllers/template.php */
