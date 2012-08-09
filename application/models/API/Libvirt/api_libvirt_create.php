<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_libvirt_create extends ImpulseModel {

	public function host($systemName, $uri, $password=null) {
		$sql = "SELECT * FROM api.create_libvirt_host(
			{$this->db->escape($systemName)},
			{$this->db->escape($uri)},
			{$this->db->escape($password)}
		)";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		return new LibvirtHost(
			$query->row()->system_name,
			$query->row()->uri,
			$query->row()->password,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
	
}
/* End of file api_libvirt_create.php */
/* Location: ./application/models/API/Libvirt/api_libvirt_create.php */
