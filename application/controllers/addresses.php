<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Addresses extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
	}

	public function index() {
		// Redirect to a useful default function
		header("Location: /systems/view/".$this->user->getActiveUser());
	}

	public function view($systemName) {
		// Decode
		$systemName = rawurldecode($systemName);

		// Instantiate
		try {
			$sys = $this->api->systems->get->systemByName($systemName);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Breadcrumb Trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail($sys->get_system_name(),"/system/view/{$sys->get_system_name()}");
		$this->_addTrail("Interfaces","/interfaces/view/{$sys->get_system_name()}");

		// Actions
		$this->_addAction('Add Interface',"/interface/create/".rawurlencode($sys->get_system_name()),"success");

		// Content
		#$content = "<div class=\"container span7\">";
		#$rowCounter = 0;
		#try {
		#	$ints = $this->api->systems->get->interfacesBySystem($sys->get_system_name());
		#	foreach($ints as $int) {
		#		if($rowCounter == 0) {
		#			$content .= "<div class=\"row-fluid\">";
		#		}
		#		elseif($rowCounter % 2 == 0) {
		#			$content .= "</div><div class=\"row-fluid\">";
		#		}
		#		$content .= $this->load->view('interface/overview',array("int"=>$int),true);
		#		$rowCounter++;
		#	}
		#}
		#catch (ObjectNotFoundException $e) {}
		#catch (Exception $e) { $this->_exit($e); return; }
		#$content .= "</div></div>";

		try {
			$ints = $this->api->systems->get->interfacesBySystem($sys->get_system_name());
			foreach($ints as $int) {
				$this->_addContentToList($this->load->view('interface/overview',array("int"=>$int),true),2);
			}

			$content = $this->_renderContentList(2);
		}
		catch (ObjectNotFoundException $e) { $content = $this->load->view('exception/objectnotfound',null,true); }
		catch (Exception $e) { $this->_exit($e); return; }

		// Sidebar
		$this->_addSidebarHeader("SYSTEMS","/systems/view/{$this->user->getActiveUser()}");
		try {
			$systems = $this->api->systems->get->systemsByOwner($this->user->getActiveUser());
			foreach($systems as $sys) {
				$this->_addSidebarItem($sys->get_system_name(),"/interfaces/view/".rawurlencode($sys->get_system_name()),"hdd");
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
