<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_libvirt_modify extends ImpulseModel {

	public function domain_state($host, $domain, $state) {
		$sql = "SELECT * FROM api.modify_domain_state(
			{$this->db->escape($host)},
			{$this->db->escape($domain)},
			{$this->db->escape($state)}
		)";
		$query = $this->db->query($sql);

		$this->_check_error($query);
	}
}
/* End of file api_libvirt_modify.php */
/* Location: ./application/models/API/Libvirt/api_libvirt_modify.php */
