<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Zones extends DnsController {
	
	public function __construct() {
		parent::__construct();
		$this->_setSubHeader("Zones");
	}

	public function index() {
		$this->_sendClient("/dns/zones/view/");
	}

	public function view($username=null)
	{
		$username = rawurldecode($username);
		// Username cannot be null in this case
		if(!$username) {
			$username = $this->user->getActiveUser();
		}

		// Breadcrumb trail
		$this->_addTrail('DNS',"/dns");
		$this->_addTrail('Zones',"/dns/zones/view/");
		$this->_addTrail($this->user->getActiveUser(),"/dns/zones/view/{$this->user->getActiveUser()}");
		
		// Actions
		$this->_addAction('Create',"/dns/zone/create");

		// Generate content
		$this->_addSidebarHeader("ZONES");
		try {
			$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			foreach($zones as $z) {
				$this->_addSidebarItem($z->get_zone(),"/dns/zone/view/".rawurlencode($z->get_zone()),"list");
			}
			$content = $this->load->view('dns/zone/information',null,true);
		}
		catch (ObjectNotFoundException $onfe) {
			$content = $this->load->view('dns/zone/information',null,true);
		}
		catch (Exception $e) {
			$this->_exit($e); return;
		}

		// Render page
		$this->_render($content);
	}
}

/* End of file zones.php */
/* Location: ./application/controllers/zones.php */
