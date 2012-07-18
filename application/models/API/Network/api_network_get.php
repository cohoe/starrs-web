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

}
/* End of file api_network_get.php */
/* Location: ./application/models/API/Network/api_network_get.php */
