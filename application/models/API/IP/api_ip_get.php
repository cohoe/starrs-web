<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseModel.php");

/**
 *	IP
 */
class Api_ip_get extends ImpulseModel {

	public function addressfamily($address) {
		$sql = "SELECT family({$this->db->escape($address)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		return $query->row()->family;
	}
	
	public function address_from_range($range) {
        // SQL query
		$sql = "SELECT api.get_address_from_range({$this->db->escape($range)})";
		$query = $this->db->query($sql);

        // Check errors
        $this->_check_error($query);
        
        // Generate and return result
		return $query->row()->get_address_from_range;
	}
	
	public function address_range($address) {
        // SQL Query
		$sql = "SELECT api.get_address_range({$this->db->escape($address)})";


		$query = $this->db->query($sql);

        // Check errors
        $this->_check_error($query);

        // Generate and return result
		return $query->row()->get_address_range;
	}

	public function rangesByGroup($group) {
		$sql = "SELECT * FROM api.get_group_ranges({$this->db->escape($group)}) ORDER BY name";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		$resultSet = array();
        foreach($query->result_array() as $range) {
            $resultSet[] = new IpRange(
                $range['first_ip'],
                $range['last_ip'],
                $range['use'],
                $range['name'],
                $range['subnet'],
                $range['class'],
                $range['comment'],
                $range['datacenter'],
                $range['zone'],
                $range['date_created'],
                $range['date_modified'],
                $range['last_modifier']
            );
        }

		return $resultSet;
	}

	public function rangesByUser($user) {
		$sql = "SELECT DISTINCT * FROM api.get_user_ranges({$this->db->escape($user)}) ORDER BY name";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		$resultSet = array();
        foreach($query->result_array() as $range) {
            $resultSet[] = new IpRange(
                $range['first_ip'],
                $range['last_ip'],
                $range['use'],
                $range['name'],
                $range['subnet'],
                $range['class'],
                $range['comment'],
                $range['datacenter'],
                $range['zone'],
                $range['date_created'],
                $range['date_modified'],
                $range['last_modifier']
            );
        }

		return $resultSet;
	}
	
	public function ranges() {
        // SQL Query
		$sql = "SELECT * FROM api.get_ip_ranges()";
		$query = $this->db->query($sql);

        // Check error
        $this->_check_error($query);

        // Generate results
        $resultSet = array();
        foreach($query->result_array() as $range) {
            $resultSet[] = new IpRange(
                $range['first_ip'],
                $range['last_ip'],
                $range['use'],
                $range['name'],
                $range['subnet'],
                $range['class'],
                $range['comment'],
                $range['datacenter'],
                $range['zone'],
                $range['date_created'],
                $range['date_modified'],
                $range['last_modifier']
            );
        }

        // Return results
        if(count($resultSet) > 0) {
            return $resultSet;
        }
        else {
            throw new ObjectNotFoundException("No ranges were found. This indicates a database error. Contact your system administrator");
        }
	}

	public function rangesBySubnet($subnet=null) {
		// SQL
		$sql = "SELECT * FROM api.get_ip_ranges() WHERE subnet = {$this->db->escape($subnet)} ORDER BY first_ip";
		$query = $this->db->query($sql);

        // Check error
        $this->_check_error($query);

        // Generate results
        $resultSet = array();
        foreach($query->result_array() as $range) {
            $resultSet[] = new IpRange(
                $range['first_ip'],
                $range['last_ip'],
                $range['use'],
                $range['name'],
                $range['subnet'],
                $range['class'],
                $range['comment'],
                $range['datacenter'],
                $range['zone'],
                $range['date_created'],
                $range['date_modified'],
                $range['last_modifier']
            );
        }

	   return $resultSet;
	}

	public function rangesByZone($datacenter=null, $zone=null) {
		// SQL
		$sql = "SELECT * FROM api.get_ip_ranges() WHERE datacenter = {$this->db->escape($datacenter)} AND zone = {$this->db->escape($zone)} ORDER BY first_ip";
		$query = $this->db->query($sql);

        // Check error
        $this->_check_error($query);

        // Generate results
        $resultSet = array();
        foreach($query->result_array() as $range) {
            $resultSet[] = new IpRange(
                $range['first_ip'],
                $range['last_ip'],
                $range['use'],
                $range['name'],
                $range['subnet'],
                $range['class'],
                $range['comment'],
                $range['datacenter'],
                $range['zone'],
                $range['date_created'],
                $range['date_modified'],
                $range['last_modifier']
            );
        }

	   return $resultSet;
	}
	
	
	public function range($name) {
        // SQL Query
        // Because PHP is stupid, that's why.
        $name = html_entity_decode($name);
		$sql = "SELECT * FROM api.get_ip_ranges() WHERE name = {$this->db->escape($name)}";
		$query = $this->db->query($sql);

        // Check error
        $this->_check_error($query);


		if($query->num_rows() > 1) {
			throw new AmbiguousTargetException("Multiple results returned by API. Contact your system administrator");
		}
		return new IpRange(
			$query->row()->first_ip,
			$query->row()->last_ip,
			$query->row()->use,
			$query->row()->name,
			$query->row()->subnet,
			$query->row()->class,
			$query->row()->comment,
			$query->row()->datacenter,
			$query->row()->zone,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
	
	public function subnets($username=null,$group=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_ip_subnets({$this->db->escape($username)})";
		
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $subnet) {
			$resultSet[] = new Subnet(
				$subnet['name'],
				$subnet['subnet'],
				$subnet['zone'],
				$subnet['owner'],
				$subnet['autogen'],
				$subnet['dhcp_enable'],
				$subnet['comment'],
				$subnet['datacenter'],
				$subnet['vlan'],
				$subnet['date_created'],
				$subnet['date_modified'],
				$subnet['last_modifier']
			);
			
		}
		
		// Return results
        if(count($resultSet) > 0) {
            return $resultSet;
        }
        else {
            throw new ObjectNotFoundException("No Subnets were found. This may or may not be bad. Contact your system administrator");
        }
	}
	
	public function subnet($subnet) {
		// SQL Query
		$sql = "SELECT * FROM api.get_ip_subnets(null) WHERE subnet = {$this->db->escape($subnet)}";
		
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		// Generate results		
		$sNet = new Subnet(
			$query->row()->name,
			$query->row()->subnet,
			$query->row()->zone,
			$query->row()->owner,
			$query->row()->autogen,
			$query->row()->dhcp_enable,
			$query->row()->comment,
			$query->row()->datacenter,
			$query->row()->vlan,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
		
		// Return result
		return $sNet;
	}
	
	public function uses() {
		// SQL Query
		$sql = "SELECT api.get_ip_range_uses()";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $use) {
			$resultSet[] = $use['get_ip_range_uses'];
		}

		// Return results
		if(count($resultSet) > 0) {
			return $resultSet;
		}
		else {
			throw new ObjectNotFoundException("No IP range uses found.");
		}
	}

	public function rangeStatsByName($range) {
		// SQL
		$sql = "SELECT * FROM api.get_range_utilization({$this->db->escape($range)})";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		return $query->row();
	}

	public function subnetStats($subnet) {
		// SQL
		$sql = "SELECT * FROM api.get_subnet_utilization({$this->db->escape($subnet)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		return $query->row();
	}

	public function subnetsByVlan($datacenter, $vlan) {
		// SQL Query
		$sql = "SELECT * FROM api.get_ip_subnets(null) WHERE datacenter = {$this->db->escape($datacenter)} AND vlan = {$this->db->escape($vlan)}";
		
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		// Generate results
		$resultSet = array();
		foreach($query->result_array() as $subnet) {
			$resultSet[] = new Subnet(
				$subnet['name'],
				$subnet['subnet'],
				$subnet['zone'],
				$subnet['owner'],
				$subnet['autogen'],
				$subnet['dhcp_enable'],
				$subnet['comment'],
				$subnet['datacenter'],
				$subnet['vlan'],
				$subnet['date_created'],
				$subnet['date_modified'],
				$subnet['last_modifier']
			);
			
		}
		
		return $resultSet;
	}

	public function range_top_users($range) {
		$sql = "SELECT * FROM api.get_range_top_users({$this->db->escape($range)})";
		$query = $this->db->query($sql);
		$this->_check_error($query);

		return $query->result_array();
	}

    public function range_groups($range) {
        $sql = "SELECT * FROM api.get_range_groups({$this->db->escape($range)})";
        $query = $this->db->query($sql);
        $this->_check_error($query);
        $resultSet = array();
        foreach($query->result_array() as $group) {
            $resultSet[] = new Group(
                $group['group'],
                $group['privilege'],
                $group['comment'],
                $group['renew_interval'],
                $group['date_created'],
                $group['date_modified'],
                $group['last_modifier']
            );
        }

        return $resultSet;
    }
}
/* End of file api_ip_get.php */
/* Location: ./application/models/API/IP/api_ip_get.php */
