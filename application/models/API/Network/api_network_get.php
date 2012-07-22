<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_network_get extends ImpulseModel {

	public function cam($systemName) {
		// SQL
		$sql = "SELECT * FROM api.get_system_cam({$this->db->escape($systemName)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		return $query->result_array();
	}
	
	public function snmp($systemName) {
		$sql = "SELECT * FROM api.get_network_snmp({$this->db->escape($systemName)})";
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

	public function interface_ports($mac) {
		$sql = "SELECT * FROM api.get_interface_switchports({$this->db->escape($mac)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		return $query->result_array();
	}

	public function switchports($system) {
		$sql = "SELECT * FROM api.get_system_switchports({$this->db->escape($system)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		$resultSet = array();
		foreach($query->result_array() as $port) {
			$resultSet[] = new Switchport(
				$port['system_name'],
				$port['name'],
				$port['description'],
				$port['alias'],
				$port['index'],
				$port['admin_state'],
				$port['oper_state'],
				$port['trunk'],
				$port['date_created'],
				$port['date_modified'],
				$port['last_modifier']
			);
		}

		return $resultSet;
	}

	public function vlans($datacenter=null) {
		$sql = "SELECT * FROM api.get_vlans({$this->db->escape($datacenter)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		$resultSet = array();
		foreach($query->result_array() as $vlan) {
			$resultSet[] = new Vlan(
				$vlan['datacenter'],
				$vlan['vlan'],
				$vlan['name'],
				$vlan['comment'],
				$vlan['date_created'],
				$vlan['date_modified'],
				$vlan['last_modifier']
			);
		}

		return $resultSet;
	}

	public function vlan($datacenter,$vlan) {
		$sql = "SELECT * FROM api.get_vlans({$this->db->escape($datacenter)}) WHERE vlan = {$this->db->escape($vlan)}";
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
/* End of file api_network_get.php */
/* Location: ./application/models/API/Network/api_network_get.php */
