<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datacenter extends ImpulseObject {
	
	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	private $datacenter;
	private $comment;
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR

    public function __construct($datacenter, $comment, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Object specific data
		$this->datacenter    = $datacenter;
        	$this->comment = $comment;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_datacenter()    { return $this->datacenter; }
	public function get_comment() { return $this->comment; }
	

    ////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_datacenter($new) {
		$this->CI->api->systems->modify->datacenter($this->datacenter, 'datacenter', $new);
		$this->datacenter= $new;
	}
	
	public function set_comment($new) {
		$this->CI->api->systems->modify->datacenter($this->datacenter, 'comment', $new);
		$this->comment = $new;
	}
	

    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
    
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file Datacenter.php */
/* Location: ./application/libraries/objects/Datacenter.php */
