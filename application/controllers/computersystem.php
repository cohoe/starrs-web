<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class ComputerSystem extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
	}

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
			#$aRecs = $this->api->dns->get->addressesBySystem($systemName);
			#foreach($aRecs as $aRec) {
			#	$this->_addSidebarItem("<li><a href=\"#\">{$aRec->get_hostname()}.{$aRec->get_zone()}</a></li>");
			#}
			$recs = $this->api->dns->get->recordsBySystem($systemName);
			foreach($recs as $rec) {
				switch(get_class($rec)) {
					case 'AddressRecord':
						$this->_addSidebarItem("<li><a href=\"#\">{$rec->get_hostname()}.{$rec->get_zone()} ({$rec->get_type()})</a></li>");
						break;
					case 'CnameRecord':
						$this->_addSidebarItem("<li><a href=\"#\">{$rec->get_alias()}.{$rec->get_zone()} ({$rec->get_type()})</a></li>");
						break;
					case 'MxRecord':
						$this->_addSidebarItem("<li><a href=\"#\">{$rec->get_hostname()}.{$rec->get_zone()} ({$rec->get_type()})</a></li>");
						break;
					case 'SrvRecord':
						$this->_addSidebarItem("<li><a href=\"#\">{$rec->get_alias()}.{$rec->get_zone()} ({$rec->get_type()})</a></li>");
						break;
					case 'TextRecord':
						$this->_addSidebarItem("<li><a href=\"#\">{$rec->get_hostname()}.{$rec->get_zone()} ({$rec->get_type()})</a></li>");
						break;
					default:
						throw new Exception("WTF?");
						break;
				}
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
		}

		// Render page
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			$this->_create();
		}
		else {
		// Breadcrumb trail
		$this->_addTrail("Systems","/systems/");

		// View data
		$viewData['sysTypes'] = $this->api->systems->get->types();
		$viewData['operatingSystems'] = $this->api->systems->get->operatingSystems();
		$viewData['owner'] = ($this->user->getActiveUser() == 'all') ? $this->user->get_user_name() : $this->user->getActiveUser();
		$viewData['isAdmin'] = $this->user->isAdmin();
		$content=$this->load->view('system/create',$viewData,true);
		$content .= $this->load->view('core/forminfo',null,true);
		$this->_render($content);
		}
	}

	public function remove($systemName) {
		$systemName = rawurldecode($systemName);
		try {
			$this->api->systems->remove->system($systemName);
			header("Location: /systems/view/".$this->user->getActiveUser());
		}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
		}
	}

	private function _create() {
		try {
			$sys = $this->api->systems->create->system(
				$this->input->post('systemName'),
				$this->input->post('owner'),
				$this->input->post('type'),
				$this->input->post('osName'),
				$this->input->post('comment')
			);

			$this->_sendClient("/system/view/{$sys->get_system_name()}");
		}
		catch(Exception $e) {
			$this->load->view('exceptions/modalerror',array('exception'=>$e));
		}
	}
}

/* End of file systems.php */
/* Location: ./application/controllers/systems.php */
