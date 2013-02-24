<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_management_modify extends ImpulseModel {
	
	public function site_configuration($directive, $value) {
		// SQL Query
		$sql = "SELECT api.modify_site_configuration(
			{$this->db->escape($directive)},
			{$this->db->escape($value)}
		)";
		$query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}

	public function group($group, $field, $value) {
		// SQL Query
		$sql = "SELECT api.modify_group(
			{$this->db->escape($group)},
			{$this->db->escape($field)},
			{$this->db->escape($value)}
		)";
		$query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}

	public function groupMember($group, $user, $field, $value) {
		// SQL Query
		$sql = "SELECT api.modify_group_member(
			{$this->db->escape($group)},
			{$this->db->escape($user)},
			{$this->db->escape($field)},
			{$this->db->escape($value)}
		)";
		$query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}

	public function user($olduser, $newuser) {
		$sql = "SELECT api.change_username({$this->db->escape($olduser)},{$this->db->escape($newuser)})";
		$query = $this->db->query($sql);
		$this->_check_error($query);
	}

	public function group_settings($group, $field, $value) {
		// SQL Query
		$sql = "SELECT api.modify_group_settings(
			{$this->db->escape($group)},
			{$this->db->escape($field)},
			{$this->db->escape($value)}
		)";
		$query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}
}
/* End of file api_management_modify.php */
/* Location: ./application/models/API/DNS/api_management_modify.php */
