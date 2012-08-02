<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Keys extends DnsController {

	public function __construct() {
		parent::__construct();
		$this->_setSubHeader("Keys");
	}

	public function index() {
		$this->_sendClient("/dns/keys/view/");
	}

	public function view($username=null)
	{
		$username = rawurldecode($username);
		// Usernallme cannot be null in this case
		if($this->user->getActiveUser() == 'all') { $username = null; } else { $username = $this->user->getActiveUser(); }

		// Breadcrumb trail
		$this->_addTrail('DNS',"/dns");
		$this->_addTrail('Keys',"/dns/keys/view/");
		$this->_addTrail($this->user->getActiveUser(),"/dns/keys/view/{$this->user->getActiveUser()}");
		
		// Actions
		$this->_addAction('Create',"/dns/key/create");

		// Sidebar
		$this->_addSidebarHeader("KEYS");

		// Generate content
		try {
			$keys = $this->api->dns->get->keysByUser($username);
			foreach($keys as $k) {
				$this->_addSidebarItem($k->get_keyname(),"/dns/key/view/".rawurlencode($k->get_keyname()),"check");
			}
		}
		catch (ObjectNotFoundException $onfe) {}
		catch (Exception $e) {
			$this->_exit($e); return;
		}

		$content = $this->load->view('dns/key/information',null,true);

		// Render page
		$this->_render($content);
	}
}

/* End of file keys.php */
/* Location: ./application/controllers/keys.php */
