<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Records extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DNS");
	}

	public function view($address) {
		// Decode
		$address = rawurldecode($address);

		// Instantiate
		try {
			$intAddr = $this->api->systems->get->interfaceaddressByAddress($address);
			$int = $this->api->systems->get->interfaceByMac($intAddr->get_mac());
		}
		catch (Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail("Systems","/systems/view");
		$this->_addTrail($int->get_system_name(),"/system/view/".rawurlencode($int->get_system_name()));
		$this->_addTrail("Interfaces","/interfaces/view/".rawurlencode($int->get_mac()));
		$this->_addTrail($int->get_mac(),"/interface/view/".rawurlencode($int->get_mac()));
		$this->_addTrail("Addresses","/addresses/view/".rawurlencode($int->get_mac()));
		$this->_addTrail($intAddr->get_address(),"/address/view/".rawurlencode($intAddr->get_address()));
		$this->_addTrail("DNS Records","/dns/records/view/".rawurlencode($intAddr->get_address()));
		
		// Actions
		$this->_addAction("Create","#");
		// Content
		try {
			$content = "<div class=\"span7\">";
			$recs = $this->api->dns->get->recordsByAddress($intAddr->get_address());
			if(count($recs) == 0) { throw new ObjectNotFoundException(); }
			$content .= $this->_renderDnsTable($recs,"A/AAAA");
			$content .= $this->_renderDnsTable($recs,"CNAME");
			$content .= $this->_renderDnsTable($recs,"SRV");
			$content .= $this->_renderDnsTable($recs,"TXT");
			$content .= $this->_renderDnsTable($recs,"MX");
			$content .= $this->_renderDnsTable($recs,"NS");
			$content .= "</div>";
		}
		catch (ObjectNotFoundException $e) { $content = $this->load->view('exceptions/objectnotfound',array('span'=>7),true); }
		catch (Exception $e) { $this->_exit($e); return; }

		// Sidebar
		$this->_addSidebarHeader("DNS RECORDS");
		$this->_addSidebarItem("A/AAAA","#A/AAAA","font");
		$this->_addSidebarItem("CNAME","#CNAME","hand-right");
		$this->_addSidebarItem("SRV","#SRV","wrench");
		$this->_addSidebarItem("TXT","#TXT","list-alt");
		$this->_addSidebarItem("MX","#MX","envelope");
		$this->_addSidebarItem("NS","#NS","file");

		// Render
		$this->_render($content);
	}
}
/* End of file records.php */
/* Location: ./application/controllers/dns/records.php */
