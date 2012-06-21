<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class ComputerSystem extends ImpulseController {

	public function index() {
		// Redirect to a useful default function
		header("Location: /systems/view/".$this->user->getActiveUser());
	}

	public function view($systemName=null)
	{
		// Decode
		$systemName = rawurldecode($systemName);

		// Breadcrumb trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail("$systemName","/system/view/".rawurlencode($systemName));

		// Actions
		$this->_addAction('Modify',"/system/modify/".rawurlencode($systemName));
		$this->_addAction('Remove',"/system/remove/".rawurlencode($systemName));
		$this->_addAction('Renew',"/system/renew/".rawurlencode($systemName));

		// Generate content
		try {
			$sys = $this->api->systems->get->systemByName($systemName);
			$content = $this->load->view('system/detail',array("sys"=>$sys),true);
		}
		catch (ObjectNotFoundException $onfe) {
			$content = $this->load->view('exceptions/objectnotfound',null,true);
		}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
		}

		$this->_addSidebarItem("<li class=\"nav-header\">INTERFACES</li>");
		try {
			$ints = $this->api->systems->get->interfacesBySystem($systemName);
			foreach($ints as $int) {
				$this->_addSidebarItem("<li><a href=\"#\">{$int->get_mac()} ({$int->get_name()})</a></li>");
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
		}
		$this->_addSidebarItem("<li class=\"nav-header\">ADDRESSES</li>");
		try {
			$intAddrs = $this->api->systems->get->interfaceaddressesBySystem($systemName);
			foreach($intAddrs as $intAddr) {
				$this->_addSidebarItem("<li><a href=\"#\">{$intAddr->get_address()}</a></li>");
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
		}

		$this->_addSidebarItem("<li class=\"nav-header\">DNS Records</li>");
		try {
			$aRecs = $this->api->dns->get->addressesBySystem($systemName);
			foreach($aRecs as $aRec) {
				$this->_addSidebarItem("<li><a href=\"#\">{$aRec->get_hostname()}.{$aRec->get_zone()}</a></li>");
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
		}

		// Render page
		$this->_render($content);
	}
}

/* End of file systems.php */
/* Location: ./application/controllers/systems.php */
