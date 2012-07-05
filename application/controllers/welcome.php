<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Welcome extends ImpulseController {
	public function index()
	{
		$content = $this->load->view('welcome_message',null,true);
		#$sidebar = $this->load->view('core/sidebar',null,true);
		$this->sidebar = "";
		$this->_render($content);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
