<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_libvirt_remove extends ImpulseModel {

	public function host($systemName) {
		$sql = "SELECT api.remove_libvirt_host({$this->db->escape($systemName)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);
	}
	
}
/* End of file api_libvirt_remove.php */
/* Location: ./application/models/API/Libvirt/api_libvirt_remove.php */
