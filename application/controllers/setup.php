<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Setup extends ImpulseController {


	public function index() {
		$content = $this->load->view('setup',null,true);
		$this->_render($content);
	}
}

/* End of file setup.php */
/* Location: ./application/controllers/setup.php */
