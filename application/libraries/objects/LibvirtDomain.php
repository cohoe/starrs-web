<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class LibvirtDomain extends ImpulseObject {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES

	private $hostName;
	private $systemName;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	public function __construct($hostName, $systemName, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Store the rest of the data
		$this->hostName 	= $hostName;
		$this->systemName 	= $systemName;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_host_name()         { return $this->hostName; }
	public function get_system_name()         { return $this->systemName; }
    
	////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_host_name($new) {
		$this->CI->api->libvirt->modify->domain($this->hostName, 'host_name', $new);	
		$this->hostName = $new; 
	}

	public function set_system_name($new) {
		$this->CI->api->libvirt->modify->domain($this->systemName, 'system_name', $new);	
		$this->systemName = $new; 
	}
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
	

	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file LibvirtDomain.php */
/* Location: ./application/libraries/objects/LibvirtDomain.php */
