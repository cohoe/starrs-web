<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseModel.php");

/**
 *	DNS
 */
class Api_dns_remove extends ImpulseModel {
	
	public function key($keyname) {
		// SQL Query
		$sql = "SELECT * FROM api.remove_dns_key({$this->db->escape($keyname)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
	
	public function zone($zone) {
		// SQL Query
		$sql = "SELECT * FROM api.remove_dns_zone({$this->db->escape($zone)})";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}

    public function address($address, $zone) {
		// SQL Query
		$sql = "SELECT api.remove_dns_address({$this->db->escape($address)},{$this->db->escape($zone)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}
	
	public function mx($zone, $preference) {
		// SQL Query
		$sql = "SELECT api.remove_dns_mailserver({$this->db->escape($zone)},{$this->db->escape($preference)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}

	public function ns($zone, $nameserver) {
		// SQL Query
		$sql = "SELECT api.remove_dns_ns({$this->db->escape($zone)},{$this->db->escape($nameserver)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}
	
	public function srv($alias, $zone, $priority, $weight, $port) {
		// SQL Query
		$sql = "SELECT api.remove_dns_srv({$this->db->escape($alias)},{$this->db->escape($zone)},{$this->db->escape($priority)},{$this->db->escape($weight)},{$this->db->escape($port)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}

	public function cname($alias, $zone) {
		// SQL Query
		$sql = "SELECT api.remove_dns_cname({$this->db->escape($alias)},{$this->db->escape($zone)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}
	
	public function txt($zone, $hostname, $text) {
		// SQL Query
		$sql = "SELECT api.remove_dns_txt({$this->db->escape($hostname)},{$this->db->escape($zone)},{$this->db->escape($text)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}
}
/* End of file api_dns_remove.php */
/* Location: ./application/models/API/DNS/api_dns_remove.php */
