<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "models/API/Libvirt/api_libvirt_create.php");
require_once(APPPATH . "models/API/Libvirt/api_libvirt_modify.php");
require_once(APPPATH . "models/API/Libvirt/api_libvirt_remove.php");
require_once(APPPATH . "models/API/Libvirt/api_libvirt_get.php");

class API_Libvirt extends ImpulseModel {
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR

	public function __construct() {
		parent::__construct();
		$this->create = new Api_libvirt_create();
		$this->modify = new Api_libvirt_modify();
		$this->remove = new Api_libvirt_remove();
 		$this->get    = new Api_libvirt_get();
	}

	////////////////////////////////////////////////////////////////////////
	// PUBLIC FUNCTIONS 

}
/* End of file api_libvirt.php */
/* Location: ./application/models/API/api_libvirt.php */
