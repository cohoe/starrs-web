<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SharedNetwork extends ImpulseObject {
	
	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	private $name;
	private $comment;
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR

    public function __construct($name, $comment, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Object specific data
		$this->name    = $name;
        	$this->comment = $comment;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_name()    { return $this->name; }
	public function get_comment() { return $this->comment; }
	

    ////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_name($new) {
		$this->CI->api->dhcp->modify->network($this->name, 'name', $new);
		$this->name= $new;
	}
	
	public function set_comment($new) {
		$this->CI->api->dhcp->modify->network($this->name, 'comment', $new);
		$this->comment = $new;
	}
	

    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
    
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file SharedNetwork.php */
/* Location: ./application/libraries/objects/SharedNetwork.php */
