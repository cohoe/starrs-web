<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_network_modify extends ImpulseModel {
	
	public function snmp($systemName, $field, $value) {
        // SQL Query
		$sql = "SELECT api.modify_network_snmp(
		    {$this->db->escape($systemName)},
		    {$this->db->escape($field)},
		    {$this->db->escape($value)}
		)";
		$query = $this->db->query($sql);

		// Check errors
        $this->_check_error($query);
    }

    public function switchport($systemName, $index, $field, $value) {
        // SQL Query
		$sql = "SELECT api.modify_switchport(
		    {$this->db->escape($systemName)},
		    {$this->db->escape($index)},
		    {$this->db->escape($field)},
		    {$this->db->escape($value)}
		)";
		$query = $this->db->query($sql);

		// Check errors
		$this->_check_error($query);
    }

	public function vlan($datacenter, $vlan, $field, $value) {
        // SQL Query
		$sql = "SELECT api.modify_vlan(
		    {$this->db->escape($datacenter)},
		    {$this->db->escape($vlan)},
		    {$this->db->escape($field)},
		    {$this->db->escape($value)}
		)";
		$query = $this->db->query($sql);

		// Check errors
		$this->_check_error($query);
	}
}
/* End of file api_network_modify.php */
/* Location: ./application/models/API/Network/api_network_modify.php */
