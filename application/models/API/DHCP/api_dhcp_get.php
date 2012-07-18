<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseModel.php");

/**
 *	DHCP Get
 */
class Api_dhcp_get extends ImpulseModel {

	public function configtypes($family=NULL) {
		// SQL Query
		$sql = "SELECT * FROM api.get_dhcp_config_types({$this->db->escape($family)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $configType) {
			$resultSet[] = new ConfigType(
				$configType['config'],
				$configType['comment'],
				$configType['family'],
				$configType['date_created'],
				$configType['date_modified'],
				$configType['last_modifier']
			);
		}
		
		// Return results
		if(count($resultSet) > 0) {
			return $resultSet;
		}
		else {
			throw new ObjectNotFoundException("No DHCP config types found. This is a big problem. Talk to your administrator.");
		}
	}
	
	public function classes() {
		// SQL Query
		$sql = "SELECT * FROM api.get_dhcp_classes()";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $class) {
			$resultSet[] = new ConfigClass(
				$class['class'],
				$class['comment'],
				$class['date_created'],
				$class['date_modified'],
				$class['last_modifier']
			);
		}
		
		// Return results
		if(count($resultSet) > 0) {
			return $resultSet;
		}
		else {
			throw new ObjectNotFoundException("No DHCP classes found. This is a big problem. Talk to your administrator.");
		}
	}
	
	public function _class($class) {
		// SQL Query
		$sql = "SELECT * FROM api.get_dhcp_class({$this->db->escape($class)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		if($query->num_rows() > 1) {
            throw new AmbiguousTargetException("Multiple classes found. This indicates a database error. Contact your system administrator");
        }
		
		// Generate results
		return new ConfigClass(
			$query->row()->class,
			$query->row()->comment,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);

		throw new ObjectNotFoundException("No DHCP classes found. This is a big problem. Talk to your administrator.");
	}

    public function globaloptions() {
        // SQL Query
		$sql = "SELECT * FROM api.get_dhcp_global_options()";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $config) {
			$resultSet[] = new GlobalOption(
				$config['option'],
				$config['value'],
				$config['date_created'],
				$config['date_modified'],
				$config['last_modifier']
			);
		}

		// Return results
		if(count($resultSet) > 0) {
			return $resultSet;
		}
		else {
			throw new ObjectNotFoundException("No DHCP global options found.");
		}
    }

    public function globaloptionByHash($option, $hash) {
		// SQL
		$sql = "SELECT * FROM api.get_dhcp_global_options() WHERE option = {$this->db->escape($option)} AND md5(value) = {$this->db->escape($hash)}";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate results
		return new GlobalOption(
			$query->row()->option,
			$query->row()->value,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

    public function classoptions($class) {
        // SQL Query
		$sql = "SELECT * FROM api.get_dhcp_class_options({$this->db->escape($class)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $config) {
			$resultSet[] = new ClassOption(
                $class,
				$config['option'],
				$config['value'],
				$config['date_created'],
				$config['date_modified'],
				$config['last_modifier']
			);
		}

		// Return results
		if(count($resultSet) > 0) {
			return $resultSet;
		}
		else {
			throw new ObjectNotFoundException("No DHCP class options found.");
		}
    }

    public function classoptionByHash($class, $option, $hash) {
		// SQL
		$sql = "SELECT * FROM api.get_dhcp_class_options({$this->db->escape($class)}) WHERE option = {$this->db->escape($option)} AND md5(value) = {$this->db->escape($hash)}";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate results
		return new ClassOption(
			$query->row()->class,
			$query->row()->option,
			$query->row()->value,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}


     public function subnetoptions($subnet) {
        // SQL Query
		$sql = "SELECT * FROM api.get_dhcp_subnet_options({$this->db->escape($subnet)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $config) {
			$resultSet[] = new SubnetOption(
                	$subnet,
				$config['option'],
				$config['value'],
				$config['date_created'],
				$config['date_modified'],
				$config['last_modifier']
			);
		}

		// Return results
		if(count($resultSet) > 0) {
			return $resultSet;
		}
		else {
			throw new ObjectNotFoundException("No DHCP subnet options found.");
		}
    }

    public function subnetoptionByHash($subnet, $option, $hash) {
		// SQL
		$sql = "SELECT * FROM api.get_dhcp_subnet_options({$this->db->escape($subnet)}) WHERE option = {$this->db->escape($option)} AND md5(value) = {$this->db->escape($hash)}";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate results
		return new SubnetOption(
			$query->row()->subnet,
			$query->row()->option,
			$query->row()->value,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

    public function rangeoptionByHash($range, $option, $hash) {
		// SQL
		$sql = "SELECT * FROM api.get_dhcp_range_options({$this->db->escape($range)}) WHERE option = {$this->db->escape($option)} AND md5(value) = {$this->db->escape($hash)}";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate results
		return new RangeOption(
			$query->row()->name,
			$query->row()->option,
			$query->row()->value,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

     public function rangeoptions($range) {
        // SQL Query
		$sql = "SELECT * FROM api.get_dhcp_range_options({$this->db->escape($range)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $config) {
			$resultSet[] = new RangeOption(
                $range,
				$config['option'],
				$config['value'],
				$config['date_created'],
				$config['date_modified'],
				$config['last_modifier']
			);
		}

		// Return results
		if(count($resultSet) > 0) {
			return $resultSet;
		}
		else {
			throw new ObjectNotFoundException("No DHCP range options found.");
		}
    }

	public function dhcpdconfig() {
		// SQL
		$sql = "SELECT * from api.get_dhcpd_config()";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		return $query->row()->get_dhcpd_config;
	}
}
/* End of file api_dhcp_get.php */
/* Location: ./application/models/API/DHCP/api_dhcp_get.php */
