<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Systems extends ImpulseController {

	public function index()
	{
		$systems = $this->api->systems->get->systemsByOwner('root');
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
		$sidebar = $this->load->view('core/sidebar',array('items'=>$links),true);
		$this->_render($sidebar,$content);
		
	}
}

/* End of file systems.php */
/* Location: ./application/controllers/systems.php */
