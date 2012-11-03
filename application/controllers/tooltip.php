<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Tooltip extends CI_Controller {

	public function view($schema, $object) {
		if($schema == "undefined") { $schema = null; }
		$schema = rawurldecode($schema);
		if($object == "undefined") { $object = null; }
		$object = rawurldecode($object);
		$tooltips = $this->impulselib->get_tooltips();
		if(isset($tooltips[$schema][$object])) {
		echo $tooltips[$schema][$object];
		}
	}
}

/* End of file template.php */
/* Location: ./application/controllers/template.php */
