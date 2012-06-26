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
			$content .= $this->load->view('core/table',array("table"=>$this->_renderDnsTable($recs,"A/AAAA")),true);
			$content .= $this->load->view('core/table',array("table"=>$this->_renderDnsTable($recs,"CNAME")),true);
			$content .= $this->load->view('core/table',array("table"=>$this->_renderDnsTable($recs,"SRV")),true);
			$content .= $this->load->view('core/table',array("table"=>$this->_renderDnsTable($recs,"TXT")),true);
			$content .= $this->load->view('core/table',array("table"=>$this->_renderDnsTable($recs,"MX")),true);
			$content .= $this->load->view('core/table',array("table"=>$this->_renderDnsTable($recs,"NS")),true);
			$content .= "</div>";
		}
		catch (ObjectNotFoundException $e) { $content = "None"; }
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

	private function _renderDnsTable($recs, $header) {
		$table = "<a name=\"$header\"></a>";
		$table .= "<table class=\"table table-striped table-bordered\">";
		switch($header) {
			case "A/AAAA":
				$table .= "<tr><td colspan=5><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Hostname</th><th>Zone</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $aRec) {
					if(get_class($aRec) != "AddressRecord") { continue; }
					$modifyLink = "/dns/address/modify/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$removeLink = "/dns/address/remove/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$table .= "<tr><td>{$aRec->get_hostname()}</td><td>{$aRec->get_zone()}</td><td>{$aRec->get_ttl()}</td><td>{$aRec->get_type()}</td><td><a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
				}
				break;
			case "CNAME":
				$table .= "<tr><td colspan=6><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Alias</th><th>Hostname</th><th>Zone</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $cRec) {
					if(get_class($cRec) != "CnameRecord") { continue; }
					$modifyLink = "/dns/cname/modify/".rawurlencode($cRec->get_zone())."/".rawurlencode($cRec->get_alias());
					$removeLink = "/dns/cname/remove/".rawurlencode($cRec->get_zone())."/".rawurlencode($cRec->get_alias());
					$table .= "<tr><td>{$cRec->get_alias()}</td><td>{$cRec->get_hostname()}</td><td>{$cRec->get_zone()}</td><td>{$cRec->get_ttl()}</td><td>{$cRec->get_type()}</td><td><a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
				}
				break;
			case "SRV":
				$table .= "<tr><td colspan=9><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Alias</th><th>Hostname</th><th>Zone</th><th>Priority</th><th>Weight</th><th>Port</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $sRec) {
					if(get_class($sRec) != "SrvRecord") { continue; }
					$modifyLink = "/dns/srv/modify/".rawurlencode($sRec->get_zone())."/".rawurlencode($sRec->get_alias())."/".$sRec->get_priority()."/".$sRec->get_weight()."/".$sRec->get_port();
					$removeLink = "/dns/srv/remove/".rawurlencode($sRec->get_zone())."/".rawurlencode($sRec->get_alias())."/".$sRec->get_priority()."/".$sRec->get_weight()."/".$sRec->get_port();
					$table .= "<tr><td>{$sRec->get_alias()}</td><td>{$sRec->get_hostname()}</td><td>{$sRec->get_zone()}</td><td>{$sRec->get_priority()}</td><td>{$sRec->get_weight()}</td><td>{$sRec->get_port()}</td><td>{$sRec->get_ttl()}</td><td>{$sRec->get_type()}</td><td><a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
				}
				break;
			case "TXT":
				$table .= "<tr><td colspan=6><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Hostname</th><th>Zone</th><th>Text</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $tRec) {
					if(get_class($tRec) != "TextRecord") { continue; }
					$modifyLink = "/dns/text/modify/".rawurlencode($tRec->get_zone())."/".rawurlencode($tRec->get_hostname())."/".rawurlencode($tRec->get_text());
					$removeLink = "/dns/text/remove/".rawurlencode($tRec->get_zone())."/".rawurlencode($tRec->get_hostname())."/".rawurlencode($tRec->get_text());
					$table .= "<tr><td>{$tRec->get_hostname()}</td><td>{$tRec->get_zone()}</td><td>{$tRec->get_text()}</td><td>{$tRec->get_ttl()}</td><td>{$tRec->get_type()}</td><td><a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
				}
				break;
			case "NS":
				$table .= "<tr><td colspan=5><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Nameserver</th><th>Zone</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $nRec) {
					if(get_class($nRec) != "NsRecord") { continue; }
					$modifyLink = "/dns/ns/modify/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$removeLink = "/dns/ns/remove/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$table .= "<tr><td>{$nRec->get_nameserver()}</td><td>{$nRec->get_zone()}</td><td>{$nRec->get_ttl()}</td><td>{$nRec->get_type()}</td><td><a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
				}
				break;
			case "MX":
				$table .= "<tr><td colspan=6><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Hostname</th><th>Zone</th><th>Preference</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $mRec) {
					if(get_class($mRec) != "MxRecord") { continue; }
					$modifyLink = "/dns/mx/modify/".rawurlencode($mRec->get_zone())."/".rawurlencode($mRec->get_hostname());
					$removeLink = "/dns/mx/remove/".rawurlencode($mRec->get_zone())."/".rawurlencode($mRec->get_hostname());
					$table .= "<tr><td>{$mRec->get_hostname()}</td><td>{$mRec->get_zone()}</td><td>{$mRec->get_preference()}</td><td>{$mRec->get_ttl()}</td><td>{$mRec->get_type()}</td><td><a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
				}
				break;
				break;

		}

		$table .= "</table>";

		return $table;
	}
}

/* End of file records.php */
/* Location: ./application/controllers/dns/records.php */
