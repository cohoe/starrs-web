<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Systems extends ImpulseController {

	public function __construct() {
		parent::__construct();
		self::$trail["Systems"] = "/systems";
	}

	public function index() {
		header("Location: /systems/view/{$this->impulselib->get_view_username()}");
	}

	public function view($username=null)
	{
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
		}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
		}
		$this->_render($content,$links=null);
	}
}

/* End of file systems.php */
/* Location: ./application/controllers/systems.php */
