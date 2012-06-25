<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Address extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
	}

	public function index() {
		// Redirect to a useful default function
		header("Location: /systems/view/".$this->user->getActiveUser());
	}

	public function view($address) {
		// Decode
		$address = rawurldecode($address);

		// Instantiate
		try {
			$intAddr = $this->api->systems->get->interfaceaddressByAddress($address);
			$int = $this->api->systems->get->interfaceByMac($intAddr->get_mac());
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Breadcrumb Trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail($int->get_system_name(),"/system/view/{$int->get_system_name()}");
		$this->_addTrail("Interfaces","/interfaces/view/{$int->get_system_name()}");
		$this->_addTrail($int->get_mac(),"/interface/view/".rawurlencode($int->get_mac()));
		$this->_addTrail("Addresses","/addresses/view/".rawurlencode($int->get_mac()));
		$this->_addTrail($intAddr->get_address(),"/address/view/".rawurlencode($intAddr->get_address()));

		// Actions
		#$this->_addAction('Add Address',"/address/create/".rawurlencode($mac),"success");
		$this->_addAction('Modify',"/address/modify/".rawurlencode($intAddr->get_address()));
		$this->_addAction('Remove',"/address/remove/".rawurlencode($intAddr->get_address()));

		// Content
		$content = $this->load->view('interfaceaddress/detail',array("intAddr"=>$intAddr),true);

		// Sidebar
		try {
			$recs = $this->api->dns->get->recordsByAddress($intAddr->get_address());
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_exit($e); return; }

		$this->_addSidebarHeader("DNS RECORDS");
		$this->_addSidebarDnsRecords($recs);

		// Render
		$this->_render($content);
	}
}

/* End of file address.php */
/* Location: ./application/controllers/address.php */
