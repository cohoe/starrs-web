<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This class contains the definition for a the System object. A system is 
 * essentially a server/machine that is part of the network.
 */
class System extends ImpulseObject {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	// string	A descriptive comment about the system
	private $comment;
	
	// bool		Whether or not the system is complete (contains interfaces)
	private $hasInterfaces;
	
	// array<InterfaceObjects>	The interfaces associated with the system
	private $interfaces;
	
	// string	The OS that the system is running
	private $osName;
	
	// string	The user who owns the system
	private $owner;
	
	private $platform;
	
	private $asset;
	
	private $group;
	
	// string	The name of the system
	private $systemName;
	
	// string	The type of system
	private $type;

    // string   The family of the type of system
    private $family;

    private $datacenter;

    private $location;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	/**
	 * @param	string	$systemName		The name of the system to create
	 * @param	string	$owner			The owning username of the system
	 * @param	string	$comment		A comment on the system
	 * @param	string	$type			The type of system
     * @param	string	$family			The family of the type of system
	 * @param	string	$osName			The name of the primary operating system
	 * @param	long	$dateCreated	Unix timestamp when the record was created
	 * @param	long	$dateModified	Unix timestamp when the record was modifed
	 * @param	string	$lastModifier	The last user to modify the record
	 */
	public function __construct($systemName, $owner, $comment, $type, $family, $osName, $platform, $asset, $group, $datacenter, $location, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Store the rest of the data
		$this->systemName 	= $systemName;
		$this->owner 		= $owner;
		$this->comment 		= $comment;
		$this->type			= $type;
          $this->family		= $family;
		$this->osName		= $osName;
		$this->platform = $platform;
		$this->asset = $asset;
		$this->group = $group;
		$this->datacenter = $datacenter;
		$this->location = $location;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_system_name()   { return $this->systemName; }
	public function get_owner()         { return $this->owner; }
	public function get_comment()       { return $this->comment; }
	public function get_type()          { return $this->type; }
     public function get_family()        { return $this->family; }
	public function get_os_name()       { return $this->osName; }
	public function get_platform()         { return $this->platform; }
	public function get_asset()         { return $this->asset; }
	public function get_group()         { return $this->group; }
	public function get_datacenter()         { return $this->datacenter; }
	public function get_location()         { return $this->location; }
    
	////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_system_name($new) {
		$this->CI->api->systems->modify->system($this->systemName, 'system_name', $new);	
		$this->systemName = $new; 
	}
	
	public function set_owner($new) { 
		$this->CI->api->systems->modify->system($this->systemName, 'owner', $new);
		$this->owner = $new; 
	}
	
	public function set_comment($new) { 
		$this->CI->api->systems->modify->system($this->systemName, 'comment', $new);
		$this->comment = $new; 
	}
	
	public function set_type($new) { 
		$this->CI->api->systems->modify->system($this->systemName, 'type', $new);
		$this->type = $new; 
	}
	
	public function set_os_name($new) { 
		$this->CI->api->systems->modify->system($this->systemName, 'os_name', $new);
		$this->osName = $new; 
	}
	
	public function set_platform($new) {
		$this->CI->api->systems->modify->system($this->systemName, 'platform_name', $new);
		$this->platform = $new; 
	}
	
	public function set_asset($new) {
		$this->CI->api->systems->modify->system($this->systemName, 'asset', $new);
		$this->asset = $new; 
	}
	
	public function set_group($new) {
		$this->CI->api->systems->modify->system($this->systemName, 'group', $new);
		$this->group = $new; 
	}

	public function set_datacenter($new) {
		$this->CI->api->systems->modify->system($this->systemName, 'datacenter', $new);
		$this->datacenter = $new; 
	}

	public function set_location($new) {
		$this->CI->api->systems->modify->system($this->systemName, 'location', $new);
		$this->location = $new; 
	}

	////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
	

	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file System.php */
/* Location: ./application/libraries/objects/System.php */
