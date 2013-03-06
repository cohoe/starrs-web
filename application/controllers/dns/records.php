<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Records extends DnsController {

	public function __construct() {
		parent::__construct();
		$this->_setSubHeader("Records");
		$this->_addScript("/js/dns.js");
	}

	public function index() {
		$this->_addTrail("DNS","/dns/");
		$this->_addTrail("Records","/dns/records/");
		$this->_addSidebarHeader("ADDRESSES");
		try {
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			foreach($systems as $sys) {
				try {
					$intAddrs = $this->api->systems->get->interfaceaddressesBySystem($sys->get_system_name());
					foreach($intAddrs as $intAddr) {
						if($intAddr->get_dynamic() == 'f') {
							$this->_addSidebarItem($intAddr->get_address()." ({$sys->get_system_name()})","/dns/records/view/".rawurlencode($intAddr->get_address()),"globe");
						} else {
							$this->_addSidebarItem("Dynamic ({$sys->get_system_name()})","/dns/records/view/".rawurlencode($intAddr->get_address()),"globe");
						}
					}
				}
				catch (ObjectNotFoundException $e) {}
				catch (Exception $e) { $this->_error($e); return; }
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) { $this->_error($e); return; }
		$content = $this->load->view('dns/recordinfo',null,true);
		$this->_render($content);
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
		$this->_addTrail("Interfaces","/interfaces/view/".rawurlencode($int->get_system_name()));
		$this->_addTrail($int->get_mac(),"/interface/view/".rawurlencode($int->get_mac()));
		$this->_addTrail("Addresses","/addresses/view/".rawurlencode($int->get_mac()));
		if($intAddr->get_dynamic() == 'f') {
			$this->_addTrail($intAddr->get_address(),"/address/view/".rawurlencode($intAddr->get_address()));
		} else {
			$this->_addTrail("Dynamic","/address/view/".rawurlencode($intAddr->get_address()));
		}
		$this->_addTrail("DNS Records","/dns/records/view/".rawurlencode($intAddr->get_address()));
		
		// Actions
		$this->_addAction("Create","/dns/records/create/".rawurlencode($intAddr->get_address()));
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

		$content .= $this->load->view('dns/modalcreate',null,true);

		// Render
		$this->_render($content);
	}

	public function create($address=null) {
		$recTypes = $this->api->dns->get->recordtypes();
		$this->load->view('dns/recordselect',array('types'=>$recTypes,'address'=>$address));
	}

	public function check_hostname($zone=null, $hostname=null) {
		print $this->api->dns->check_hostname($hostname, $zone);
	}
}
/* End of file records.php */
/* Location: ./application/controllers/dns/records.php */
