<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class LibvirtHost extends ImpulseObject {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES

	private $systemName;

	private $uri;

	private $password;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	public function __construct($systemName, $uri, $password, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Store the rest of the data
		$this->systemName 	= $systemName;
		$this->uri 	= $uri;
		$this->password 	= $password;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_system_name()   { return $this->systemName; }
	public function get_uri()         { return $this->uri; }
	public function get_password()         { return $this->password; }
    
	////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_system_name($new) {
		$this->CI->api->systems->modify->host($this->systemName, 'system_name', $new);	
		$this->systemName = $new; 
	}
	
	public function set_uri($new) { 
		$this->CI->api->libvirt->modify->host($this->systemName, 'uri', $new);
		$this->uri = $new; 
	}
	
	public function set_password($new) { 
		$this->CI->api->libvirt->modify->host($this->systemName, 'password', $new);
		$this->password = $new; 
	}
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
	

	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file LibvirtHost.php */
/* Location: ./application/libraries/objects/LibvirtHost.php */
