<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Addresses extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_addScript("/js/systems.js");
	}

	public function view($mac) {
		// Decode
		$mac = rawurldecode($mac);

		// Instantiate
		try {
			$int = $this->api->systems->get->interfaceByMac($mac);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Breadcrumb Trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail($int->get_system_name(),"/system/view/{$int->get_system_name()}");
		$this->_addTrail("Interfaces","/interfaces/view/{$int->get_system_name()}");
		$this->_addTrail($int->get_mac(),"/interface/view/".rawurlencode($int->get_mac()));

		// Actions
		$this->_addAction('Add Address',"/address/create/".rawurlencode($int->get_mac()),"success");

		// Content
		try {
			$intAddrs = $this->api->systems->get->interfaceaddressesByMac($int->get_mac());
			foreach($intAddrs as $intAddr) {
				$this->_addContentToList($this->load->view('interfaceaddress/overview',array("intAddr"=>$intAddr),true),2);
			}

			$content = $this->_renderContentList(2);
		}
		catch (ObjectNotFoundException $e) { $content = $this->load->view('exceptions/objectnotfound',array('span'=>7),true); }
		catch (Exception $e) { $this->_exit($e); return; }

		// Sidebar
		$this->_addSidebarHeader("INTERFACES");
		try {
			$ints = $this->api->systems->get->interfacesBySystem($int->get_system_name());
			foreach($ints as $int) {
				$this->_addSidebarItem($int->get_mac(),"/addresses/view/".rawurlencode($int->get_mac()),"road");
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) { $this->_exit($e); return; }

		// Render
		$this->_render($content);
	}
}

/* End of file addresses.php */
/* Location: ./application/controllers/addresses.php */
