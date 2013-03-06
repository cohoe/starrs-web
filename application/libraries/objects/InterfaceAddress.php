<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class contains the definition of an InterfaceAddress object. These
 * objects represent an address tied to the
 * specified address.
 */
class InterfaceAddress extends ImpulseObject {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	// string   The address bound to the interface
	private $address;
	
	// string   The class of the address (all values are default so far)
	private $class;
	
	// string   A comment about the address
	private $comment;
	
	// string   The config type for the address
	// @todo: make a getValidConfigTypes method
	private $config;
	
	// int	    The family the address belongs to (either IPv4 or v6).
	private $family;
	
	// string   The mac address that this address is bound to. Can be used to lookup the matching InterfaceObject.
	private $mac;
	
	// bool     Is this address the primary for the interface
	private $isPrimary;
	
	// string   The name of the containing system
	private $systemName;
	
	// string   The name of the containing range
	private $range;

    // boolean  Is this address dynamically assigned
	private $dynamic;

	private $renewDate;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	/**
	 * @param 	string 	$address		The address bound to the address
	 * @param 	string 	$class			The class of the address
	 * @param 	string	$config			How the address is configured
	 * @param 	string 	$mac			The mac address the interface address is bound to
	 * @param	bool	$isPrimary		Is this address the primary for the interface?
	 * @param 	string	$comment		A comment about the address
	 * @param	long	$dateCreated	Unix timestamp when the address was created
	 * @param	long	$dateModified	Unix timestamp when the address was modified
	 * @param	string	$lastModifier	The last user to modify the address
	 */
	public function __construct($address, $class, $config, $mac, $isPrimary, $comment, $renewDate, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// InterfaceAddress-specific stuff
		$this->address   = $address;
		$this->class     = $class;
		$this->config    = $config;
		$this->mac       = $mac;
		$this->comment   = $comment; 
		$this->isPrimary = $isPrimary;
		$this->renewDate = $renewDate;
		
		// Determine the family of the address based on whether there's a : or not
		$this->family  = (strpos($address, ':') === false) ? 4 : 6;
		
		// Initialize variables
        $this->dynamic = $this->CI->api->ip->is_dynamic($this->address);

        // Try to get the address record that resolves to this address
	   $this->systemName = $this->CI->api->systems->get->systemByAddress($this->address)->get_system_name();

		$this->range = $this->CI->api->ip->get->address_range($this->address);
	}
	
	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_address()         { return $this->address; }
	public function get_class()           { return $this->class; }
	public function get_config()          { return $this->config; }
	public function get_mac()             { return $this->mac; }
	public function get_comment()         { return $this->comment; }
	public function get_family()          { return $this->family; }
	public function get_isprimary()       { return $this->isPrimary; }
	public function get_fqdn()            { return $this->dnsFqdn; }
	public function get_rules()           { return $this->fwRules; }
	public function get_renew_date()      { return $this->renewDate; }
	public function get_system_name()     { return $this->systemName; }
	public function get_range()           { return $this->range; }
	public function get_dynamic()		  { return $this->dynamic; }
	
	////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_address($new) {
		$this->CI->api->systems->modify->interface_address($this->address, 'address', $new);	
		$this->address = $new; 
	}
	
	public function set_config($new) {
		$this->CI->api->systems->modify->interface_address($this->address, 'config', $new);	
		$this->config = $new; 
	}
	
	public function set_class($new) {
		$this->CI->api->systems->modify->interface_address($this->address, 'class', $new);	
		$this->class = $new; 
	}
	
	public function set_isprimary($new) {
		$this->CI->api->systems->modify->interface_address($this->address, 'isprimary', $new);	
		$this->isPrimary = $new; 
	}
	
	public function set_comment($new) {
		$this->CI->api->systems->modify->interface_address($this->address, 'comment', $new);	
		$this->comment = $new; 
	}

	public function set_mac($new) {
		$this->CI->api->systems->modify->interface_address($this->address, 'mac', $new);
		$this->mac = $new;
	}

	public function set_renew_date($new) {
		$this->CI->api->systems->modify->interface_address($this->address, 'renew_date', $new);
		$this->renew_date = $new;
	}
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
	
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file InterfaceAddress.php */
/* Location: ./application/libraries/objects/InterfaceAddress.php */
