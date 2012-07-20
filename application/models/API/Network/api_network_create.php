<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_network_create extends ImpulseModel {
	
	public function snmp($system, $address, $ro, $rw) {
		$sql = "SELECT * FROM api.create_network_snmp(
			{$this->db->escape($system)},
			{$this->db->escape($address)},
			{$this->db->escape($ro)},
			{$this->db->escape($rw)}
		)";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		return new SnmpCred(
			$query->row()->system_name,
			$query->row()->address,
			$query->row()->ro_community,
			$query->row()->rw_community,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function vlan($datacenter, $vlan, $name, $comment) {
		$sql = "SELECT * FROM api.create_vlan(
			{$this->db->escape($datacenter)},
			{$this->db->escape($vlan)},
			{$this->db->escape($name)},
			{$this->db->escape($comment)}
		)";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		return new Vlan(
			$query->row()->datacenter,
			$query->row()->vlan,
			$query->row()->name,
			$query->row()->comment,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
}
/* End of file api_network_create.php */
/* Location: ./application/models/API/Network/api_network_create.php */
