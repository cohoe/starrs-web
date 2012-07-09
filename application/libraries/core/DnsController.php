<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");
/**
 */
class DnsController extends ImpulseController {

	public function __construct() {
		parent::__construct();
		
		// Nav
		$this->_setNavHeader("DNS");
		$this->_addTrail("DNS","/dns");
	}

	private function _renderDnsTableButtons($viewLink, $modifyLink, $removeLink) {
		$actions = "<a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger pull-right\">Remove</button></a><span class=\"pull-right\">&nbsp</span>";
		$actions .= "<a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning pull-right\">Modify</button></a><span class=\"pull-right\">&nbsp</span>";
		$actions .= "<a href=\"$viewLink\"><button class=\"btn btn-info btn-mini pull-right\">Details</button></a>";
		return $actions;
	}

	protected function _renderDnsTable($recs, $header, $counter=0) {
		$ttlHead = "<th style=\"width: 3em\">TTL</th>";
		$portHead= "<th style=\"width: 3em\">Port</th>";
		$weightHead= "<th style=\"width: 3.6em\">Weight</th>";
		$priorityHead= "<th style=\"width: 3.6em\">Priority</th>";
		$typeHead= "<th style=\"width: 3.6em\">Type</th>";
		$table = "<a name=\"$header\"></a>";
		$table .= "<table class=\"table table-striped table-bordered imp-dnstable\">";
		$table .= "<div class=\"imp-dnsheader\"><h3>$header</h3></div>";
		switch($header) {
			case "Zone A/AAAA":
				$table .= "<tr><th>Zone</th><th style=\"width: 9%\">TTL</th><th>Type</th><th>Address</th><th style=\"width: 162px;\">Actions</th></tr>";
				foreach($recs as $aRec) {
					if(get_class($aRec) != "ZoneAddressRecord") { continue; }
					$viewLink = "/dns/zonea/view/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$modifyLink = "/dns/zonea/modify/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$removeLink = "/dns/zonea/remove/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$actions = $this->_renderDnsTableButtons($viewLink, $modifyLink, $removeLink);
					$table .= "<tr><td>{$aRec->get_zone()}</td><td>{$aRec->get_ttl()}</td><td>{$aRec->get_type()}</td><td>{$aRec->get_address()}</td><td>$actions</td></tr>";
					$counter++;
				}
				break;
			case "A/AAAA":
				$table .= "<tr><th>Hostname</th><th>Zone</th>$ttlHead$typeHead<th style=\"width: 162px; max-width: 50px;\">Actions</th></tr>";
				foreach($recs as $aRec) {
					if(get_class($aRec) != "AddressRecord") { continue; }
					$viewLink = "/dns/a/view/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$modifyLink = "/dns/a/modify/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$removeLink = "/dns/a/remove/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$actions = $this->_renderDnsTableButtons($viewLink, $modifyLink, $removeLink);
					$table .= "<tr><td>{$aRec->get_hostname()}</td><td>{$aRec->get_zone()}</td><td>{$aRec->get_ttl()}</td><td>{$aRec->get_type()}</td><td>$actions</td></tr>";
					$counter++;
				}
				break;
			case "CNAME":
				$table .= "<tr><th>Alias</th><th>Zone</th>$ttlHead<th>Owner</th><th style=\"width: 162px\">Actions</th></tr>";
				foreach($recs as $cRec) {
					if(get_class($cRec) != "CnameRecord") { continue; }
					$viewLink = "/dns/cname/view/".rawurlencode($cRec->get_zone())."/".rawurlencode($cRec->get_alias());
					$modifyLink = "/dns/cname/modify/".rawurlencode($cRec->get_zone())."/".rawurlencode($cRec->get_alias());
					$removeLink = "/dns/cname/remove/".rawurlencode($cRec->get_zone())."/".rawurlencode($cRec->get_alias());
					$actions = $this->_renderDnsTableButtons($viewLink, $modifyLink, $removeLink);
					$table .= "<tr><td>{$cRec->get_alias()}</td><td>{$cRec->get_zone()}</td><td>{$cRec->get_ttl()}</td><td>{$cRec->get_owner()}</td><td>$actions</td></tr>";
					$counter++;
				}
				break;
			case "SRV":
				$table .= "<tr><th style=\"width: 20%\">Alias</th><th>Zone</th>$priorityHead$weightHead$portHead<th style=\"width: 162px\">Actions</th></tr>";
				foreach($recs as $sRec) {
					if(get_class($sRec) != "SrvRecord") { continue; }
					$viewLink = "/dns/srv/view/".rawurlencode($sRec->get_zone())."/".rawurlencode($sRec->get_alias())."/".$sRec->get_priority()."/".$sRec->get_weight()."/".$sRec->get_port();
					$modifyLink = "/dns/srv/modify/".rawurlencode($sRec->get_zone())."/".rawurlencode($sRec->get_alias())."/".$sRec->get_priority()."/".$sRec->get_weight()."/".$sRec->get_port();
					$removeLink = "/dns/srv/remove/".rawurlencode($sRec->get_zone())."/".rawurlencode($sRec->get_alias())."/".$sRec->get_priority()."/".$sRec->get_weight()."/".$sRec->get_port();
					$actions = $this->_renderDnsTableButtons($viewLink, $modifyLink, $removeLink);
					$table .= "<tr><td>{$sRec->get_alias()}</td><td>{$sRec->get_zone()}</td><td>{$sRec->get_priority()}</td><td>{$sRec->get_weight()}</td><td>{$sRec->get_port()}</td><td>$actions</td></tr>";
					$counter++;
				}
				break;
			case "Zone TXT":
				$table .= "<tr><th style=\"width: 16%\">Hostname</th><th style=\"width: 15%\">Zone</th><th>Text</th><th style=\"width: 162px\">Actions</th></tr>";
				foreach($recs as $tRec) {
					if(get_class($tRec) != "ZoneTextRecord") { continue; }
					$viewLink = "/dns/zonetxt/view/".rawurlencode($tRec->get_zone())."/".md5($tRec->get_text());
					$modifyLink = "/dns/zonetxt/modify/".rawurlencode($tRec->get_zone())."/".md5($tRec->get_text());
					$removeLink = "/dns/zonetxt/remove/".rawurlencode($tRec->get_zone())."/".md5($tRec->get_text());
					$actions = $this->_renderDnsTableButtons($viewLink, $modifyLink, $removeLink);
					$table .= "<tr><td>{$tRec->get_hostname()}</td><td>{$tRec->get_zone()}</td><td><div style=\"word-wrap: break-word\">{$tRec->get_text()}</div></td><td>$actions</td></tr>";
					$counter++;
				}
				break;
			case "TXT":
				$table .= "<tr><th>Hostname</th><th>Zone</th><th>Text</th><th style=\"width: 162px\">Actions</th></tr>";
				foreach($recs as $tRec) {
					if(get_class($tRec) != "TextRecord") { continue; }
					$viewLink = "/dns/txt/view/".rawurlencode($tRec->get_zone())."/".rawurlencode($tRec->get_hostname())."/".md5($tRec->get_text());
					$modifyLink = "/dns/txt/modify/".rawurlencode($tRec->get_zone())."/".rawurlencode($tRec->get_hostname())."/".md5($tRec->get_text());
					$removeLink = "/dns/txt/remove/".rawurlencode($tRec->get_zone())."/".rawurlencode($tRec->get_hostname())."/".md5($tRec->get_text());
					$actions = $this->_renderDnsTableButtons($viewLink, $modifyLink, $removeLink);
					$table .= "<tr><td>{$tRec->get_hostname()}</td><td>{$tRec->get_zone()}</td><td>{$tRec->get_text()}</td><td>$actions</td></tr>";
					$counter++;
				}
				break;
			case "Zone NS":
				$table .= "<tr><th>Nameserver</th><th>Address</th>$ttlHead<th style=\"width: 162px\">Actions</th></tr>";
				foreach($recs as $nRec) {
					if(get_class($nRec) != "NsRecord") { continue; }
					$viewLink = "/dns/ns/view/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$modifyLink = "/dns/ns/modify/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$removeLink = "/dns/ns/remove/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$actions = $this->_renderDnsTableButtons($viewLink, $modifyLink, $removeLink);
					$table .= "<tr><td>{$nRec->get_nameserver()}</td><td>{$nRec->get_address()}</td><td>{$nRec->get_ttl()}</td><td>$actions</td></tr>";
					$counter++;
				}
				break;
			case "NS":
				$table .= "<tr><th>Nameserver</th><th>Zone</th>$ttlHead<th style=\"width: 162px\">Actions</th></tr>";
				foreach($recs as $nRec) {
					if(get_class($nRec) != "NsRecord") { continue; }
					$viewLink = "/dns/ns/view/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$modifyLink = "/dns/ns/modify/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$removeLink = "/dns/ns/remove/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$actions = $this->_renderDnsTableButtons($viewLink, $modifyLink, $removeLink);
					$table .= "<tr><td>{$nRec->get_nameserver()}</td><td>{$nRec->get_zone()}</td><td>{$nRec->get_ttl()}</td><td>$actions</td></tr>";
					$counter++;
				}
				break;
			case "MX":
				$table .= "<tr><th>Hostname</th><th>Zone</th><th style=\"width: 5.6em\">Preference</th><th style=\"width: 9%\">TTL</th><th style=\"width: 162px\">Actions</th></tr>";
				foreach($recs as $mRec) {
					if(get_class($mRec) != "MxRecord") { continue; }
					$viewLink = "/dns/mx/view/".rawurlencode($mRec->get_zone())."/".rawurlencode($mRec->get_preference());
					$modifyLink = "/dns/mx/modify/".rawurlencode($mRec->get_zone())."/".rawurlencode($mRec->get_preference());
					$removeLink = "/dns/mx/remove/".rawurlencode($mRec->get_zone())."/".rawurlencode($mRec->get_preference());
					$actions = $this->_renderDnsTableButtons($viewLink, $modifyLink, $removeLink);
					$table .= "<tr><td>{$mRec->get_hostname()}</td><td>{$mRec->get_zone()}</td><td>{$mRec->get_preference()}</td><td>{$mRec->get_ttl()}</td><td>$actions</td></tr>";
					$counter++;
				}
				break;
		}

		$table .= "</table>";

		if($counter == 0) {
			return;
		}
		else {
			return $this->load->view('core/table',array("table"=>$table),true);
		}
	}
}
/* End of file DnsController.php */
/* Location: ./application/libraries/core/DnsController.php */
