<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_systems_modify extends ImpulseModel {
	
	public function system($systemName, $field, $newValue) {
		// Deal with value
		if($newValue == "") {
			$newValue = null;
		}
		// SQL Query
		$sql = "SELECT api.modify_system({$this->db->escape($systemName)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
	
	public function _interface($mac, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_interface({$this->db->escape($mac)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
	
	public function interface_address($address, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_interface_address({$this->db->escape($address)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}

	public function datacenter($datacenter, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_datacenter({$this->db->escape($datacenter)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}

	public function availabilityzone($datacenter, $zone, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_availability_zone({$this->db->escape($datacenter)}, {$this->db->escape($zone)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}

	public function platform($name, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_platform({$this->db->escape($name)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
}
/* End of file api_systems_modify.php */
/* Location: ./application/models/API/Systems/api_systems_modify.php */
