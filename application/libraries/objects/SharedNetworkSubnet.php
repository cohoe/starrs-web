<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SharedNetworkSubnet extends ImpulseObject {
	
	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	private $name;
	private $subnet;
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR

    public function __construct($name, $subnet, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Object specific data
		$this->name    = $name;
        	$this->subnet = $subnet;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_name()    { return $this->name; }
	public function get_subnet() { return $this->subnet; }
	

    ////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_name($new) {
		$this->CI->api->dhcp->modify->network_subnet($this->name, $this->subnet, 'name', $new);
		$this->name= $new;
	}
	
	public function set_subnet($new) {
		$this->CI->api->dhcp->modify->network_subnet($this->name, $this->subnet, 'subnet', $new);
		$this->subnet = $new;
	}
	

    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
    
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file SharedNetworkSubnet.php */
/* Location: ./application/libraries/objects/SharedNetworkSubnet.php */
