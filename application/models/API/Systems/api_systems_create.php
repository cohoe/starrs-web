<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_systems_create extends ImpulseModel {
	
	public function system($systemName,$owner=NULL,$type,$osName,$comment) {
		// SQL Query
		$sql = "SELECT * FROM api.create_system(
			{$this->db->escape($systemName)},
			{$this->db->escape($owner)},
			{$this->db->escape($type)},
			{$this->db->escape($osName)},
			{$this->db->escape($comment)})";
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

}
/* End of file api_systems_create.php */
/* Location: ./application/models/API/Systems/api_systems_create.php */
