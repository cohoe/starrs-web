<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Systems extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_addScript("/js/systems.js");
	}

	public function view($username=null) {
		$this->_setSubHeader("Systems");
		$username = rawurldecode($username);
		// Username cannot be null in this case
		if(!$username) {
			$username = $this->user->getActiveUser();
		}

		// Breadcrumb trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail($this->user->getActiveUser(),"/systems/view/{$this->user->getActiveUser()}");
		
		// Actions
		$this->_addAction('Create',"/system/create");
		$this->_addAction('Create (Quick)',"/system/quickcreate");

		// Generate content
		$this->_addSidebarHeader("SYSTEMS");
		try {
			$systems = $this->api->systems->get->systemsByOwner($username);
			foreach($systems as $sys) {
				$this->_addSidebarItem($sys->get_system_name(),"/system/view/".rawurlencode($sys->get_system_name()),"hdd");
			}
		}
		catch (ObjectNotFoundException $onfe) { }
		catch(Exception $e) { $this->_exit($e); return; }

		$content = $this->load->view('system/information',null,true);

		// Render page
		$this->_render($content);
	}

	public function viewrenew($username=null) {
		$this->_setSubHeader("Renew");
		$username = rawurldecode($username);
		// Username cannot be null in this case
		if(!$username) {
			$username = $this->user->getActiveUser();
		}

		// Breadcrumb trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail($this->user->getActiveUser(),"/systems/view/{$this->user->getActiveUser()}");
		
		// Actions
		$this->_addAction('Renew All',"/system/renew/all");

		// Generate content
		$this->_addSidebarHeader("SYSTEMS");

		$viewData = array();

		try {
			$systems = $this->api->systems->get->systemsByOwner($username);
			$links = array();
			foreach($systems as $sys) {
				try {
					$intAddrs = $this->api->systems->get->interfaceaddressesBySystem($sys->get_system_name());
					$viewData[$sys->get_system_name()] = $intAddrs;
				}
				catch(ObjectNotFoundException $e) { $viewData[$sys->get_system_name()] = array(); }
				catch(Exception $e) { $this->_exit($e); return; }

				$this->_addSidebarItem($sys->get_system_name(),"/system/view/".rawurlencode($sys->get_system_name()),"hdd");
			}
			$content = $this->load->view('system/viewrenew',array('systems'=>$systems,'sysIntAddrs'=>$viewData),true);
		}
		catch (ObjectNotFoundException $onfe) {
			$content = $this->load->view('system/information',null,true);
		}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
		}

		// Render page
		$this->_render($content);
	}
}

/* End of file systems.php */
/* Location: ./application/controllers/systems.php */
