<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class InterfaceController extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
	}

	public function index() {
		// Redirect to a useful default function
		header("Location: /systems/view/".$this->user->getActiveUser());
	}

	public function view($mac) {
		// Decode
		$mac = rawurldecode($mac);

		// Instantiate
		try {
			$int = $this->api->systems->get->interfaceByMac($mac);
		}
		catch(Exception $e) {
			$this->_exit($e);
			return;
		}

		// Breadcrumb Trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail($int->get_system_name(),"/system/view/{$int->get_system_name()}");
		$this->_addTrail("Interfaces","/interfaces/view/{$int->get_system_name()}");
		$this->_addTrail("$mac","/interface/view/".rawurlencode($mac));

		// Actions
		$this->_addAction('Add Address',"/address/create/".rawurlencode($mac),"success");
		$this->_addAction('Modify',"/interface/modify/".rawurlencode($mac));
		$this->_addAction('Remove',"/interface/remove/".rawurlencode($mac));

		// Content
		$content = $this->load->view('interface/detail',array("int"=>$int),true);

		// Sidebar
		$recs = array();

		$this->_addSidebarHeader("ADDRESSES");
		try {
			$intAddrs = $this->api->systems->get->interfaceaddressesByMac($int->get_mac());
			foreach($intAddrs as $intAddr) {
				$this->_addSidebarItem($intAddr->get_address(),"#","globe");
				try {
					$recs = array_merge($recs,$this->api->dns->get->recordsByAddress($intAddr->get_address()));
				}
				catch (Exception $e) {}
			}
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) {
			$this->_exit($e);
			return;
		}
		$this->_addSidebarHeader("ADDRESSES");
		$this->_addSidebarDnsRecords($recs);

		// Render
		$this->_render($content);

	}
}

/* End of file networkinterface.php */
/* Location: ./application/controllers/networkinterface.php */
