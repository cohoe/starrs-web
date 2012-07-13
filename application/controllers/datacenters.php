<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Datacenters extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_setSubHeader("Datacenters");
		$this->_addTrail("Datacenters","/datacenters");
	}

	public function index() {
		$this->_sendClient("/datacenters/view/");
	}

	public function view() {
		try {
			$dcs = $this->api->systems->get->datacenters();
		}
		catch(ObjectNotFoundException $e) { $dcs = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		$this->_addSidebarHeader("DATACENTERS");

		foreach($dcs as $dc) {
			$this->_addSidebarItem($dc->get_datacenter(),"/datacenter/view/".rawurlencode($dc->get_datacenter()),"home");
		}

		$content = $this->load->view('datacenter/information',null,true);

		$this->_addAction("Create","/datacenter/create/");

		$this->_render($content);
	}
}

/* End of file datacenters.php */
/* Location: ./application/controllers/datacenters.php */
