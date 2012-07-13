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
			$resultSet[] = new System(
				$system['system_name'],
				$system['owner'],
				$system['comment'],
				$system['type'],
				$system['family'],
				$system['os_name'],
				$system['renew_date'],
				$system['platform_name'],
				$system['asset'],
				$system['group'],
				$system['datacenter'],
				$system['date_created'],
				$system['date_modified'],
				$system['last_modifier']				
			);
		}

		// Return results
		return $resultSet;
	}

	public function systemsByDatacenter($datacenter=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_systems(null) AS sysdata JOIN api.get_system_types() AS typedata ON sysdata.type = typedata.type WHERE datacenter = {$this->db->escape($datacenter)} ORDER BY system_name;";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $system) {
			// Instantiate a new system object
			$resultSet[] = new System(
				$system['system_name'],
				$system['owner'],
				$system['comment'],
				$system['type'],
				$system['family'],
				$system['os_name'],
				$system['renew_date'],
				$system['platform_name'],
				$system['asset'],
				$system['group'],
				$system['datacenter'],
				$system['date_created'],
				$system['date_modified'],
				$system['last_modifier']				
			);
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
			$query->row()->platform_name,
			$query->row()->asset,
			$query->row()->group,
			$query->row()->datacenter,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);

		return $sys;
	}

	public function interfaceByMac($mac=null) {
		// SQL
		$sql = "SELECT * FROM api.get_system_interfaces(null) WHERE mac={$this->db->escape($mac)}";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Generate results
		$int = new NetworkInterface(
			$query->row()->mac,
			$query->row()->comment,
			$query->row()->system_name,
			$query->row()->name,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);

		return $int;
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
			$resultSet[] = new NetworkInterface(
				$interface['mac'],
				$interface['comment'],
				$interface['system_name'],
				$interface['name'],
				$interface['date_created'],
				$interface['date_modified'],
				$interface['last_modifier']
			);
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
			$resultSet[] = new InterfaceAddress(
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
		}

		// Return results
		return $resultSet;
	}

	public function interfaceaddressesByMac($mac=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_system_interface_addresses(null) WHERE mac = {$this->db->escape($mac)} ORDER BY family(address),address;";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $interfaceAddress) {
			$resultSet[] = new InterfaceAddress(
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
		}

		// Return results
		return $resultSet;
	}

	public function interfaceaddressesByRange($range=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_system_interface_addresses(null) WHERE api.get_address_range(address) = {$this->db->escape($range)} ORDER BY family(address),address;";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $interfaceAddress) {
			$resultSet[] = new InterfaceAddress(
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
		}

		// Return results
		return $resultSet;
	}

	public function interfaceaddressByAddress($address=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_system_interface_address({$this->db->escape($address)})";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		return new InterfaceAddress(
			$query->row()->address,
			$query->row()->class,
			$query->row()->config,
			$query->row()->mac,
			$query->row()->isprimary,
			$query->row()->comment,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
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

	public function systemByAddress($address=null) {
		// SQL
		$sql = "SELECT * FROM api.get_systems(null) AS sysdata JOIN api.get_system_types() as typedata ON sysdata.type = typedata.type WHERE system_name = api.get_interface_address_system({$this->db->escape($address)});";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);
		
		// Result
		return new System(
			$query->row()->system_name,
			$query->row()->owner,
			$query->row()->comment,
			$query->row()->type,
			$query->row()->family,
			$query->row()->os_name,
			$query->row()->renew_date,
			$query->row()->platform_name,
			$query->row()->asset,
			$query->row()->group,
			$query->row()->datacenter,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function platforms() {
		// SQL
		$sql = "SELECT * FROM api.get_platforms()";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Result
		$resultSet = array();
		foreach($query->result_array() as $platform) {
			$resultSet[] = new Platform(
				$platform['platform_name'],
				$platform['architecture'],
				$platform['disk'],
				$platform['cpu'],
				$platform['memory'],
				$platform['date_created'],
				$platform['date_modified'],
				$platform['last_modifier']
			);
		}

		return $resultSet;
	}

	public function platformByName($name=null) {
		// SQL
		$sql = "SELECT * FROM api.get_platforms() WHERE platform_name = {$this->db->escape($name)}";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Result
		return new Platform(
			$query->row()->platform_name,
			$query->row()->architecture,
			$query->row()->disk,
			$query->row()->cpu,
			$query->row()->memory,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function datacenters() {
		// SQL
		$sql = "SELECT * FROM api.get_datacenters()";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Results
		$resultSet = array();
		foreach($query->result_array() as $dc) {
			$resultSet[] = new DataCenter(
				$dc['datacenter'],
				$dc['comment'],
				$dc['date_created'],
				$dc['date_modified'],
				$dc['last_modifier']
			);
		}

		return $resultSet;
	}

	public function datacenterByName($name=null) {
		// SQL
		$sql = "SELECT * FROM api.get_datacenters() WHERE datacenter = {$this->db->escape($name)}";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Results
		return new DataCenter(
			$query->row()->datacenter,
			$query->row()->comment,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function availabilityzonesByDatacenter($datacenter=null) {
		// SQL
		$sql = "SELECT * FROM api.get_availability_zones() WHERE datacenter = {$this->db->escape($datacenter)}";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Results
		$resultSet = array();
		foreach($query->result_array() as $zone) {
			$resultSet[] = new AvailabilityZone(
				$zone['datacenter'],
				$zone['zone'],
				$zone['comment'],
				$zone['date_created'],
				$zone['date_modified'],
				$zone['last_modifier']
			);
		}

		return $resultSet;
	}

	public function availabilityzone($datacenter=null,$zone=null) {
		// SQL
		$sql = "SELECT * FROM api.get_availability_zones() WHERE datacenter = {$this->db->escape($datacenter)} AND zone = {$this->db->escape($zone)}";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Results
		return new AvailabilityZone(
			$query->row()->datacenter,
			$query->row()->zone,
			$query->row()->comment,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
}
/* End of file api_systems_get.php */
/* Location: ./application/models/API/Systems/api_systems_get.php */
