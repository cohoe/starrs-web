<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseModel.php");

/**
 *	IP
 */
class Api_ip_create extends ImpulseModel {
	
	public function subnet($subnet, $name, $comment, $autogen, $dhcp, $zone, $owner, $datacenter, $vlan) {
		// SQL Query
		$sql = "SELECT * FROM api.create_ip_subnet(
			{$this->db->escape($subnet)},
			{$this->db->escape($name)},
			{$this->db->escape($comment)},
			{$this->db->escape($autogen)},
			{$this->db->escape($dhcp)},
			{$this->db->escape($zone)},
			{$this->db->escape($owner)},
			{$this->db->escape($datacenter)},
			{$this->db->escape($vlan)}
		)";
		
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		if($query->num_rows() > 1) {
			throw new APIException("The database returned more than one subnet. Contact your system administrator");
		}
		
		// Generate and return result
		return new Subnet(
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
	}
	
	public function range($name, $firstIp, $lastIp, $subnet, $use, $class, $comment, $datacenter, $zone) {
		// SQL Query
		$sql = "SELECT * FROM api.create_ip_range(
			{$this->db->escape($name)},
			{$this->db->escape($firstIp)},
			{$this->db->escape($lastIp)},
			{$this->db->escape($subnet)},
			{$this->db->escape($use)},
			{$this->db->escape($class)},
			{$this->db->escape($comment)},
			{$this->db->escape($datacenter)},
			{$this->db->escape($zone)}
		)";

		
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		if($query->num_rows() > 1) {
			throw new APIException("The database returned more than one subnet. Contact your system administrator");
		}

		// Generate and return result
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

	public function rangegroup($range, $group) {
		$sql = "SELECT * FROM api.create_range_group(
			{$this->db->escape($range)},
			{$this->db->escape($group)}
		)";

		$query = $this->db->query($sql);

		$this->_check_error($query);
	}
	
	// @todo: IP address range. 
}
/* End of file api_ip_create.php */
/* Location: ./application/models/API/IP/api_ip_create.php */
