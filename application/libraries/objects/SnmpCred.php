<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class SnmpCred extends ImpulseObject {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	private $systemName;

	private $address;

	private $roCommunity;

	private $rwCommunity;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	public function __construct($systemName, $address, $roCommunity, $rwCommunity, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Store the rest of the data
		$this->systemName = $systemName;
		$this->address = $address;
		$this->roCommunity = $roCommunity;
		$this->rwCommunity = $rwCommunity;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_system_name() { return $this->systemName; }
	public function get_address() { return $this->address; }
	public function get_ro_community() { return $this->roCommunity; }
	public function get_rw_community() { return $this->rwCommunity; }

	////////////////////////////////////////////////////////////////////////
	// SETTERS

	public function set_system_name($new) {
		$this->CI->api->network->modify->snmp($this->systemName, 'system_name', $new);
		$this->platformName = $new;
	}
	public function set_address($new) {
		$this->CI->api->network->modify->snmp($this->systemName, 'address', $new);
		$this->platformName = $new;
	}
	public function set_rw_community($new) {
		$this->CI->api->network->modify->snmp($this->systemName, 'rw_community', $new);
		$this->rwCommunity = $new;
	}
	public function set_ro_community($new) {
		$this->CI->api->network->modify->snmp($this->systemName, 'ro_community', $new);
		$this->roCommunity = $new;
	}
    
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file SnmpCred.php */
/* Location: ./application/libraries/objects/SnmpCred.php */
