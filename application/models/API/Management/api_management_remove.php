<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_management_remove extends ImpulseModel {
	
	public function site_configuration($directive) {
		// SQL Query
		$sql = "SELECT api.remove_site_configuration({$this->db->escape($directive)})";
		$query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}

	public function group($group) {
		// SQL Query
		$sql = "SELECT api.remove_group({$this->db->escape($group)})";
		$query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}

	public function groupMember($group, $user) {
		// SQL Query
		$sql = "SELECT api.remove_group_member({$this->db->escape($group)}, {$this->db->escape($user)})";
		$query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}

	public function group_settings($group) {
		// SQL Query
		$sql = "SELECT api.remove_group_settings({$this->db->escape($group)})";
		$query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}
}
/* End of file api_management_remove.php */
/* Location: ./application/models/API/DNS/api_management_remove.php */
