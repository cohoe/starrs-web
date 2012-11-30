<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Welcome extends ImpulseController {
	public function index()
	{
		if($this->impulselib->getViewMode() == "Advanced") {
			$content = $this->load->view('welcome_message',null,true);
		} else {
			$content = $this->load->view('welcome_message_simple',array('helpContact'=>$this->api->get->site_configuration('HELP_CONTACT')),true);
		}
		#$sidebar = $this->load->view('core/sidebar',null,true);
		$this->sidebar = "";
		$this->_render($content);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
