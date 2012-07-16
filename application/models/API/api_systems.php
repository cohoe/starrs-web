<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "models/API/Systems/api_systems_create.php");
require_once(APPPATH . "models/API/Systems/api_systems_modify.php");
require_once(APPPATH . "models/API/Systems/api_systems_remove.php");
require_once(APPPATH . "models/API/Systems/api_systems_get.php");

class API_Systems extends ImpulseModel {
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR

	public function __construct() {
		parent::__construct();
		$this->create = new Api_systems_create();
		$this->modify = new Api_systems_modify();
		$this->remove = new Api_systems_remove();
 		$this->get    = new Api_systems_get();
	}

	////////////////////////////////////////////////////////////////////////
	// PUBLIC FUNCTIONS 

	public function renew($address) {
		// SQL Query
		$sql = "SELECT api.renew_interface_address({$this->db->escape($address)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
}
/* End of file api_systems.php */
/* Location: ./application/models/API/api_systems.php */
