<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseModel.php");

/**
 *	DNS
 */
class Api_dns_modify extends ImpulseModel {
	
	public function key($keyname, $field, $value) {
		// SQL Query
		$sql = "SELECT api.modify_dns_key(
			{$this->db->escape($keyname)},
			{$this->db->escape($field)},
			{$this->db->escape($value)}
		)";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
	
	public function zone($zone, $field, $value) {
		// SQL Query
		$sql = "SELECT api.modify_dns_zone(
			{$this->db->escape($zone)},
			{$this->db->escape($field)},
			{$this->db->escape($value)}
		)";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}

    public function address($address, $zone, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_dns_address({$this->db->escape($address)}, {$this->db->escape($zone)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}
	
	public function mailserver($hostname, $zone, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_dns_mailserver({$this->db->escape($hostname)}, {$this->db->escape($zone)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}

	public function ns($zone, $nameserver, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_dns_ns({$this->db->escape($zone)}, {$this->db->escape($nameserver)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}

	public function srv($alias, $zone, $priority, $weight, $port, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_dns_srv({$this->db->escape($alias)}, {$this->db->escape($zone)}, {$this->db->escape($priority)}, {$this->db->escape($weight)}, {$this->db->escape($port)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}

	public function cname($alias, $zone, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_dns_cname({$this->db->escape($alias)}, {$this->db->escape($zone)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}

	public function txt($hostname, $zone, $text, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_dns_txt({$this->db->escape($hostname)}, {$this->db->escape($zone)}, {$this->db->escape($text)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}

	public function zone_address($zone, $address, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_dns_zone_a({$this->db->escape($zone)}, {$this->db->escape($address)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}

	public function zone_text($hostname, $zone, $text, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_dns_zone_txt({$this->db->escape($hostname)}, {$this->db->escape($zone)}, {$this->db->escape($text)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}

	public function soa($zone, $field, $newValue) {
		// SQL Query
		$sql = "SELECT api.modify_dns_soa({$this->db->escape($zone)}, {$this->db->escape($field)}, {$this->db->escape($newValue)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}
}
/* End of file api_dns_modify.php */
/* Location: ./application/models/API/DNS/api_dns_modify.php */
