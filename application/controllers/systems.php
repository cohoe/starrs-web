<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Systems extends ImpulseController {

	public function index() {
		// Redirect to a useful default function
		header("Location: /systems/view/".$this->user->getActiveUser());
	}

	public function view($username=null)
	{
		// Breadcrumb trail
		self::$trail["Systems"] = "/systems";
		self::$trail[$this->user->getActiveUser()] = "/systems/view/{$this->user->getActiveUser()}";

		// Generate content
		try {
			$systems = $this->api->systems->get->systemsByOwner($username);
			$links = array();
			$content = "<div class=\"row-fluid\">";
			$rowCounter = 0;
			foreach($systems as $system) {
				$links[$system->get_system_name()]['link'] = "/system/view/{$system->get_system_name()}";
				$links[$system->get_system_name()]['text'] = $system->get_system_name();
				if(($rowCounter % 3) == 0) {
					$content .= "</div>\n<div class=\"row-fluid\">";
				}
				$content .= $this->load->view('system/overview',array(
					'systemName' => $system->get_system_name(),
					'type' => $system->get_type(),
					'os' => $system->get_os_name(),
					'owner' => $system->get_owner(),
					'dateCreated' => $system->get_date_created(),
					'dateModified' => $system->get_date_modified(),
					'lastModifier' => $system->get_last_modifier(),
					'comment' => $system->get_comment(),
					'renewDate' => $system->get_renew_date()
				),true);
				$rowCounter++;
			}
			$content .= "</div>";
		}
		catch (ObjectNotFoundException $onfe) {
			$content = $this->load->view('exceptions/objectnotfound',null,true);
			$links = null;
		}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
			$links = null;
		}

		$content = $this->load->view('system/information',null,true);

		// Render page
		$this->_render($content,$links);
	}
}

/* End of file systems.php */
/* Location: ./application/controllers/systems.php */
