<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Welcome extends DnsController {

	public function index() {
		// Sidebar
		$this->_addSidebarHeader("ZONES");
		try {
			$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
			foreach($zones as $zone) {
				$this->_addSidebarItem($zone->get_zone(),"/dns/zone/view/".rawurlencode($zone->get_zone()),"list");
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) { $this->_exit($e); return; }
		$this->_addSidebarHeader("KEYS");
		try {
			if($this->user->getActiveUser() == 'all') { $uname = null; } else { $uname = $this->user->getActiveUser(); }
			$keys = $this->api->dns->get->keysByOwner($uname);
			foreach($keys as $key) {
				$this->_addSidebarItem($key->get_keyname(),"/dns/key/view/".rawurlencode($key->get_keyname()),"check");
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) { $this->_exit($e); return; }
		$this->_addSidebarHeader("ADDRESSES");
		try {
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			foreach($systems as $sys) {
				try {
					$intAddrs = $this->api->systems->get->interfaceaddressesBySystem($sys->get_system_name());
					foreach($intAddrs as $intAddr) {
						$this->_addSidebarItem($intAddr->get_address()." ({$sys->get_system_name()})","/dns/records/view/".rawurlencode($intAddr->get_address()),"globe");
					}
				}
				catch (ObjectNotFoundException $e) {}
				catch (Exception $e) { $this->_exit($e); return; }
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) { $this->_exit($e); return; }

		// Actions
		$this->_addAction("Create Key","/dns/key/create","success");
		$this->_addAction("Create Zone","/dns/zone/create","success");

		// Breadcrumb
		$this->_addTrail("DNS","/dns");

		// Content
		$content = $this->load->view('dns/information',null,true);
		$this->_render($content);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/dns/welcome.php */
