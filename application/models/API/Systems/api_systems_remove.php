<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_systems_remove extends ImpulseModel {
	
	public function system($systemName) {
		// SQL Query
		$sql = "SELECT api.remove_system({$this->db->escape($systemName)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
	
	public function _interface($mac) {
		// SQL Query
		$sql = "SELECT api.remove_interface({$this->db->escape($mac)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
	
	public function interfaceaddress($address) {
		// SQL Query
		$sql = "SELECT api.remove_interface_address({$this->db->escape($address)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}

	public function datacenter($datacenter) {
		// SQL Query
		$sql = "SELECT api.remove_datacenter({$this->db->escape($datacenter)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}

	public function availabilityzone($datacenter, $zone) {
		// SQL Query
		$sql = "SELECT api.remove_availability_zone({$this->db->escape($datacenter)}, {$this->db->escape($zone)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}

	public function platform($name) {
		// SQL Query
		$sql = "SELECT api.remove_platform({$this->db->escape($name)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
}
/* End of file api_systems_remove.php */
/* Location: ./application/models/Systems/Systems/api_systems_remove.php */
