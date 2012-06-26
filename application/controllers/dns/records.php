<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Records extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DNS");
	}

	public function view($username) {
		// Sidebar
		$this->_addSidebarHeader("ZONES");
		try {
			$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			foreach($zones as $zone) {
				$this->_addSidebarItem($zone->get_zone(),"#","list");
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) { $this->_exit($e); return; }
		$this->_addSidebarHeader("KEYS");
		try {
			$keys = $this->api->dns->get->keysByOwner($this->user->getActiveUser());
			foreach($keys as $key) {
				$this->_addSidebarItem($key->get_keyname(),"#","move");
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) { $this->_exit($e); return; }
		$this->_addSidebarHeader("SYSTEMS");
		try {
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			foreach($systems as $sys) {
				$this->_addSidebarItem($sys->get_system_name(),"#","hdd");
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) { $this->_exit($e); return; }

		// Content
		$content = $this->load->view('dns/information',null,true);
		$this->_render($content);
	}
}

/* End of file records.php */
/* Location: ./application/controllers/dns/records.php */
