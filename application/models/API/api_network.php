<?php  if ( ! defined('BASEPATH')) exit('No direct scrnetworkt access allowed');
require_once(APPPATH . "libraries/core/ImpulseModel.php");
require_once(APPPATH . "models/API/Network/api_network_create.php");
require_once(APPPATH . "models/API/Network/api_network_modify.php");
require_once(APPPATH . "models/API/Network/api_network_remove.php");
require_once(APPPATH . "models/API/Network/api_network_get.php");
require_once(APPPATH . "models/API/Network/api_network_list.php");

/**
 *
 */
class Api_network extends ImpulseModel {

    /**
     *
     */
	function __construct() {
		parent::__construct();
		$this->create = new Api_network_create();
		$this->modify = new Api_network_modify();
		$this->remove = new Api_network_remove();
          $this->get    = new Api_network_get();
		$this->list   = new Api_network_list();
	}

	public function reload_cam($systemName) {
		$sql = "SELECT api.reload_cam({$this->db->escape($systemName)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);
	}

	public function reload_switchports($systemName) {
		$sql = "SELECT api.reload_network_switchports({$this->db->escape($systemName)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);
	}

}
