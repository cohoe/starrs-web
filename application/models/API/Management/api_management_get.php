<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_management_get extends ImpulseModel {

	public function current_user() {
        // SQL Query
		$sql = "SELECT api.get_current_user()";
		$query = $this->db->query($sql);

        // Check errors
        $this->_check_error($query);

        // Return result
		return $query->row()->get_current_user;
	}
	
	public function current_user_level() {
        // SQL Query
		$sql = "SELECT api.get_current_user_level()";
		$query = $this->db->query($sql);

        // Check errors
        $this->_check_error($query);

        // Return result
		return $query->row()->get_current_user_level;
	}
	
	public function site_configuration($directive) {
		// SQL Query
		$sql = "SELECT api.get_site_configuration({$this->db->escape($directive)})";
		$query = $this->db->query($sql);
		
		// Check error
        $this->_check_error($query);
		
		// Return result
		return $query->row()->get_site_configuration;
	}

	public function siteconfig($option) {
		// SQL Query
		$sql = "SELECT * FROM api.get_site_configuration_all() WHERE option = {$this->db->escape($option)}";
		$query = $this->db->query($sql);
		
		// Check error
        $this->_check_error($query);

		// return
		return new ConfigItem(
			$query->row()->option,
			$query->row()->value,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
	
	public function site_configuration_all() {
		// SQL Query
		$sql = "SELECT * FROM api.get_site_configuration_all()";
		$query = $this->db->query($sql);
		
		// Check error
        $this->_check_error($query);
		
		// Return result
		$resultSet = array();
		foreach($query->result_array() as $config) {
			$resultSet[] = new ConfigItem(
				$config['option'],
				$config['value'],
				$config['date_created'],
				$config['date_modified'],
				$config['last_modifier']
			);
		}
		return $resultSet;
	}

	public function users() {
		// SQL Query
		$sql = "SELECT DISTINCT(owner) FROM api.get_systems(null) ORDER BY owner";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return result
		$resultSet = array();
		foreach($query->result_array() as $user) {
			$resultSet[] = $user['owner'];
		}
		return $resultSet;
	}
}
/* End of file api_management_get.php */
/* Location: ./application/models/API/DNS/api_management_get.php */
