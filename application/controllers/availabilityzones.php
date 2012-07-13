<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Availabilityzones extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_setSubHeader("Availability Zones");
		$this->_addTrail("Availability Zones","/availabilityzones/view");
	}

	public function index() {
		$this->_sendClient("/availabilityzones/view/");
	}

	public function view() {
		// Instantiate
		try {
			$dcs = $this->api->systems->get->datacenters();
			foreach($dcs as $dc) {
				$this->_addSidebarHeader($dc->get_datacenter(),"/datacenter/view/".rawurlencode($dc->get_datacenter()));
				try {
					$azs = $this->api->systems->get->availabilityzonesByDatacenter($dc->get_datacenter());
				}
				catch(ObjectNotFoundException $e) { $azs = array(); }
				catch(Exception $e) { $this->_exit($e); return; }
				foreach($azs as $az) {
					$this->_addSidebarItem($az->get_zone(),"/availabilityzone/view/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone()),"folder-open");
				}
				$azs = array();
			}
		}
		catch(ObjectNotFoundException $e) { $this->_addSidebarHeader("DATACENTERS"); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Content
		$content = $this->load->view('availabilityzone/information',null,true);

		// Render
		$this->_render($content);
	}
}

/* End of file template.php */
/* Location: ./application/controllers/template.php */
