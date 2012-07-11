<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AvailabilityZone extends ImpulseObject {
	
	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	private $datacenter;
	private $zone;
	private $comment;
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR

    public function __construct($datacenter, $zone, $comment, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Object specific data
		$this->datacenter    = $datacenter;
		$this->zone    = $zone;
        	$this->comment = $comment;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_datacenter()    { return $this->datacenter; }
	public function get_zone()    { return $this->zone; }
	public function get_comment() { return $this->comment; }
	

    ////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_zone($new) {
		$this->CI->api->systems->modify->availabilityzone($this->datacenter, $this->zone, 'zone', $new);
		$this->zone= $new;
	}
	public function set_datacenter($new) {
		$this->CI->api->systems->modify->availabilityzone($this->datacenter, $this->zone, 'datacenter', $new);
		$this->datacenter= $new;
	}
	
	public function set_comment($new) {
		$this->CI->api->systems->modify->availabilityzone($this->datacenter, $this->zone, 'comment', $new);
		$this->comment = $new;
	}
	

    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
    
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file AvailabilityZone.php */
/* Location: ./application/libraries/objects/AvailabilityZone.php */
