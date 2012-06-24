<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Systems extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
	}

	public function index() {
		// Redirect to a useful default function
		header("Location: /systems/view/".$this->user->getActiveUser());
	}

	public function view($username=null)
	{
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

		// Generate content
		try {
			$systems = $this->api->systems->get->systemsByOwner($username);
			$links = array();
			foreach($systems as $system) {
				$links[$system->get_system_name()]['link'] = "/system/view/".rawurlencode($system->get_system_name());
				$links[$system->get_system_name()]['text'] = $system->get_system_name();
			}

			$content = $this->load->view('system/information',null,true);
			foreach($links as $item) {
				$this->_addSidebarItem("<li><a href=\"{$item['link']}\">{$item['text']}</a></li>");
			}
		}
		catch (ObjectNotFoundException $onfe) {
			$content = $this->load->view('exceptions/objectnotfound',null,true);
			$content .= $this->load->view('system/information',null,true);
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
