<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_systems_get extends ImpulseModel {
	
	public function systemsByOwner($owner=null) {
		// Check if should be null
		if($owner == "all") {
			$owner = null;
		}
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

	public function systemByName($name=null) {
		//SQL Query
		$sql = "SELECT * FROM api.get_systems(null) AS sysdata JOIN api.get_system_types() as typedata ON sysdata.type = typedata.type WHERE system_name = {$this->db->escape($name)};";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Generate results
		$sys = new System(
			$query->row()->system_name,
			$query->row()->owner,
			$query->row()->comment,
			$query->row()->type,
			$query->row()->family,
			$query->row()->os_name,
			$query->row()->renew_date,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);

		return $sys;
	}

	public function interfacesBySystem($systemName=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_system_interfaces({$this->db->escape($systemName)})";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $interface) {
			$int = new NetworkInterface(
				$interface['mac'],
				$interface['comment'],
				$interface['system_name'],
				$interface['name'],
				$interface['date_created'],
				$interface['date_modified'],
				$interface['last_modifier']
			);
			$resultSet[] = $int;
		}

		// Return Results
		return $resultSet;
	}

	public function interfaceaddressesBySystem($systemName=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_system_interface_addresses(null) WHERE api.get_interface_address_system(address) = {$this->db->escape($systemName)} ORDER BY family(address),address;";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $interfaceAddress) {
			$intAddr = new InterfaceAddress(
				$interfaceAddress['address'],
				$interfaceAddress['class'],
				$interfaceAddress['config'],
				$interfaceAddress['mac'],
				$interfaceAddress['isprimary'],
				$interfaceAddress['comment'],
				$interfaceAddress['date_created'],
				$interfaceAddress['date_modified'],
				$interfaceAddress['last_modifier']
			);
			$resultSet[] = $intAddr;
		}

		// Return results
		return $resultSet;
	}

	public function types() {
		// SQL Query
		$sql = "SELECT * FROM api.get_system_types()";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		$resultSet = array();
		foreach($query->result_array() as $systemType) {
			$resultSet[] = new SystemType(
				$systemType['type'],
				$systemType['family']
			);
		}

		// Return Results
		return $resultSet;
	}

	public function operatingSystems() {
		// SQL Query
		$sql = "SELECT * FROM api.get_operating_systems()";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Return
		$resultSet = array();
		foreach($query->result_array() as $os) {
			$resultSet[] = $os['get_operating_systems'];
		}
		return $resultSet;
	}
}
/* End of file api_systems_get.php */
/* Location: ./application/models/API/Systems/api_systems_get.php */
