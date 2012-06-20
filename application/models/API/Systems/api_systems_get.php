<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_systems_get extends ImpulseModel {
	
	public function systemsByOwner($owner=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_systems({$this->db->escape($owner)}) AS sysdata JOIN api.get_system_types() AS typedata ON sysdata.type = typedata.type ORDER BY system_name;";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $system) {
			// Instantiate a new system object
			$sys = new System(
				$system['system_name'],
				$system['owner'],
				$system['comment'],
				$system['type'],
				$system['family'],
				$system['os_name'],
				$system['renew_date'],
				$system['date_created'],
				$system['date_modified'],
				$system['last_modifier']
			);

			// Add the object to the results array
			$resultSet[] = $sys;
		}

		// Return results
		return $resultSet;
	}
}
/* End of file api_systems_get.php */
/* Location: ./application/models/API/Systems/api_systems_get.php */
