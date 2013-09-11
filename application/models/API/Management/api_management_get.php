<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_management_get extends ImpulseModel {

	public function current_user() {
        // SQL Query
		$sql = "SELECT api.get_current_user()";
		$query = $this->db->query($sql);

        // Check errors
        $this->_check_error($query);

        // Return result
		return $query->row()->get_current_user;
	}
	
	public function current_user_level() {
        // SQL Query
		$sql = "SELECT api.get_current_user_level()";
		$query = $this->db->query($sql);

        // Check errors
        $this->_check_error($query);

        // Return result
		return $query->row()->get_current_user_level;
	}
	
	public function site_configuration($directive) {
		// SQL Query
		$sql = "SELECT api.get_site_configuration({$this->db->escape($directive)})";
		$query = $this->db->query($sql);
		
		// Check error
        $this->_check_error($query);
		
		// Return result
		return $query->row()->get_site_configuration;
	}

	public function siteconfig($option) {
		// SQL Query
		$sql = "SELECT * FROM api.get_site_configuration_all() WHERE option = {$this->db->escape($option)}";
		$query = $this->db->query($sql);
		
		// Check error
        $this->_check_error($query);

		// return
		return new ConfigItem(
			$query->row()->option,
			$query->row()->value,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
	
	public function site_configuration_all() {
		// SQL Query
		$sql = "SELECT * FROM api.get_site_configuration_all()";
		$query = $this->db->query($sql);
		
		// Check error
        $this->_check_error($query);
		
		// Return result
		$resultSet = array();
		foreach($query->result_array() as $config) {
			$resultSet[] = new ConfigItem(
				$config['option'],
				$config['value'],
				$config['date_created'],
				$config['date_modified'],
				$config['last_modifier']
			);
		}
		return $resultSet;
	}

	public function users() {
		// SQL Query
		$sql = "SELECT DISTINCT(owner) FROM api.get_systems(null) ORDER BY owner";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return result
		$resultSet = array();
		foreach($query->result_array() as $user) {
			$resultSet[] = $user['owner'];
		}
		return $resultSet;
	}

	public function groups() {
		// SQL
		$sql = "SELECT * FROM api.get_groups()";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
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

	public function userGroups($user=null) {
		// SQL
		$sql = "SELECT * FROM api.get_user_groups({$this->db->escape($user)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
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

	public function group($group=null) {
		// SQL
        $group = html_entity_decode($group);
		$sql = "SELECT * FROM api.get_groups() WHERE \"group\" = {$this->db->escape($group)}";
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

	public function group_settings($group=null) {
		// SQL
		$sql = "SELECT * FROM api.get_group_settings({$this->db->escape($group)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
		return new GroupSettings(
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

	public function groupMembers($group) {
		// SQL
		$sql = "SELECT * FROM api.get_group_members({$this->db->escape($group)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
		$resultSet = array();
		foreach($query->result_array() as $group) {
			$resultSet[] = new GroupMember(
				$group['group'],
				$group['user'],
				$group['privilege'],
				$group['date_created'],
				$group['date_modified'],
				$group['last_modifier']
			);
		}

		return $resultSet;
	}

	public function groupMember($group, $user) {
		// SQL
		$sql = "SELECT * FROM api.get_group_members({$this->db->escape($group)}) WHERE \"user\" = {$this->db->escape($user)}";
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
}
/* End of file api_management_get.php */
/* Location: ./application/models/API/DNS/api_management_get.php */
