<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	Management
 */
class Api_libvirt_get extends ImpulseModel {

	public function hosts($username) {
		if($username == 'all') { $username = null; }
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
		if($user == 'all') { $user = null; }
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
		// @todo Make this actually do something
		return array();
		$sql = "SELECT * FROM api.get_host_domains({$this->db->escape($host)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		$resultSet = array();
		foreach($query->result_array() as $dom) {
			$resultSet[] = new LibvirtDomain(
				$dom['host_name'],
				$dom['domain_name'],
				$dom['state'],
				$dom['definition'],
				$dom['date_created'],
				$dom['date_modified'],
				$dom['last_modifier']
			);
		}

		return $resultSet;
	}

	public function domain($host, $domain) {
		$sql = "SELECT * FROM api.get_host_domain({$this->db->escape($host)}, {$this->db->escape($domain)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		return new LibvirtDomain(
			$query->row()->host_name,
			$query->row()->domain_name,
			$query->row()->state,
			$query->row()->definition,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function platform($name) {
		$sql = "SELECT * FROM api.get_libvirt_platform({$this->db->escape($name)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		return new LibvirtPlatform(
			$query->row()->platform_name,
			$query->row()->definition,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
}
/* End of file api_libvirt_get.php */
/* Location: ./application/models/API/Libvirt/api_libvirt_get.php */
