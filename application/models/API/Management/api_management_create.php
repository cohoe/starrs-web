<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_management_create extends ImpulseModel {
	
	public function log_entry($source, $severity, $message) {
		// SQL Query
		$sql = "SELECT api.create_log_entry(
			{$this->db->escape($source)},
			{$this->db->escape($severity)},
			{$this->db->escape($message)}
		)";
        $query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}
	
	public function site_configuration($directive, $value) {
		// SQL Query
		$sql = "SELECT api.create_site_configuration(
			{$this->db->escape($directive)},
			{$this->db->escape($value)}
		)";
        $query = $this->db->query($sql);
		
		// Check errors
        $this->_check_error($query);
	}

	public function group($group, $privilege, $comment, $renew) {
		// SQL
		$sql = "SELECT * FROM api.create_group(
			{$this->db->escape($group)},
			{$this->db->escape($privilege)},
			{$this->db->escape($comment)},
			{$this->db->escape($renew)}
		)";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
		return new Group(
			$query->row()->group,
			$query->row()->privilege,
			$query->row()->comment,
			$query->row()->renew_interval,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function groupMember($group, $user, $privilege) {
		// SQL
		$sql = "SELECT * FROM api.create_group_member(
			{$this->db->escape($group)},
			{$this->db->escape($user)},
			{$this->db->escape($privilege)}
		)";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
		return new GroupMember(
			$query->row()->group,
			$query->row()->user,
			$query->row()->privilege,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function group_settings($group, $privilege, $provider, $hostname, $id, $username, $password) {
		// SQL
		$sql = "SELECT * FROM api.create_group_settings(
			{$this->db->escape($group)},
			{$this->db->escape($provider)},
			{$this->db->escape($id)},
			{$this->db->escape($hostname)},
			{$this->db->escape($username)},
			{$this->db->escape($password)},
			{$this->db->escape($privilege)}
		)";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
		return new Groupsettings(
			$query->row()->group,
			$query->row()->privilege,
			$query->row()->provider,
			$query->row()->hostname,
			$query->row()->id,
			$query->row()->username,
			$query->row()->password,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
}
/* End of file api_management_create.php */
/* Location: ./application/models/API/DNS/api_management_create.php */
