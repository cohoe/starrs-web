<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_systems_create extends ImpulseModel {
	
	public function system($systemName,$owner=NULL,$type,$osName,$comment,$group=null,$platform=null,$asset=null) {
		// SQL Query
		$sql = "SELECT * FROM api.create_system(
			{$this->db->escape($systemName)},
			{$this->db->escape($owner)},
			{$this->db->escape($type)},
			{$this->db->escape($osName)},
			{$this->db->escape($comment)},
			{$this->db->escape($group)},
			{$this->db->escape($platform)},
			{$this->db->escape($asset)})";
		$query = $this->db->query($sql);

		// Check errors
		$this->_check_error($query);

		if($query->num_rows() > 1) {
			throw new APIException("The API returned multiple results?");
		}

		return new System(
			$query->row()->system_name,
			$query->row()->owner,
			$query->row()->comment,
			$query->row()->type,
			#$query->row()->family,
			null,
			$query->row()->os_name,
			$query->row()->renew_date,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function _interface($systemName=null, $mac=null, $interfaceName=null, $comment=null) {
		// SQL Query
		$sql = "SELECT * FROM api.create_interface(
			{$this->db->escape($systemName)},
			{$this->db->escape($mac)},
			{$this->db->escape($interfaceName)},
			{$this->db->escape($comment)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
		return new NetworkInterface(
			$query->row()->mac,
			$query->row()->comment,
			$query->row()->system_name,
			$query->row()->name,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function interfaceaddress($mac, $address, $config, $class, $isprimary, $comment) {
		// SQL Query
		$sql = "SELECT * FROM api.create_interface_address(
			{$this->db->escape($mac)},
			{$this->db->escape($address)},
			{$this->db->escape($config)},
			{$this->db->escape($class)},
			{$this->db->escape($isprimary)},
			{$this->db->escape($comment)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		return new InterfaceAddress(
			$query->row()->address,
			$query->row()->class,
			$query->row()->config,
			$query->row()->mac,
			$query->row()->isprimary,
			$query->row()->comment,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

}
/* End of file api_systems_create.php */
/* Location: ./application/models/API/Systems/api_systems_create.php */
