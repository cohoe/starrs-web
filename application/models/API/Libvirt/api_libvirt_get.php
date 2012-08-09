<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_libvirt_get extends ImpulseModel {

	public function hosts($username) {
		$sql = "SELECT * FROM api.get_hosts({$this->db->escape($username)}) as hostdata WHERE api.get_system_owner(hostdata.system_name) = {$this->db->escape($username)}";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		$resultSet = array();
		foreach($query->result_array() as $host) {
			$resultSet[] = new LibvirtHost(
				$host['system_name'],
				$host['uri'],
				$host['password'],
				$host['date_created'],
				$host['date_modified'],
				$host['last_modifier']
			);
		}

		return $resultSet;
	}

	public function host($name,$user) {
		$sql = "SELECT * FROM api.get_hosts({$this->db->escape($user)}) WHERE system_name = {$this->db->escape($name)}";
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

	public function domainsByHost($host) {
		$sql = "SELECT * FROM api.get_host_domains({$this->db->escape($host)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		$resultSet = array();
		foreach($query->result_array() as $dom) {
			$resultSet[] = new LibvirtDomain(
				$dom['host_name'],
				$dom['domain_name'],
				$dom['date_created'],
				$dom['date_modified'],
				$dom['last_modifier']
			);
		}

		return $resultSet;
	}
}
/* End of file api_libvirt_get.php */
/* Location: ./application/models/API/Libvirt/api_libvirt_get.php */
