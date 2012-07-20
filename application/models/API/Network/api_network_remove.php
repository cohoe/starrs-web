<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_network_remove extends ImpulseModel {
	
    public function snmp($system) {
        // SQL Query
		$sql = "SELECT api.remove_network_snmp({$this->db->escape($system)})";
		$query = $this->db->query($sql);

		// Check errors
        $this->_check_error($query);
    }

    public function vlan($datacenter, $vlan) {
        // SQL Query
		$sql = "SELECT api.remove_vlan({$this->db->escape($datacenter)}, {$this->db->escape($vlan)})";
		$query = $this->db->query($sql);

		// Check errors
        $this->_check_error($query);
    }
	
}
/* End of file api_network_remove.php */
/* Location: ./application/models/Network/Network/api_network_remove.php */
