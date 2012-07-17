<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class Group extends ImpulseObject{

	private $group; 

	private $privilege;

	private $comment;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	/**
	 */
	public function __construct($group, $privilege, $comment, $dateCreated, $dateModified, $lastModifier) {
		parent::__construct($dateCreated, $dateModified, $lastModifier);

		$this->group = $group;
		$this->privilege = $privilege;
		$this->comment = $comment;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_group()	     { return $this->group; }
	public function get_privilege()	{ return $this->privilege; }
	public function get_comment()      { return $this->comment; }

	////////////////////////////////////////////////////////////////////////
	// GETTERS

	public function set_group($new) {
		$this->CI->api->modify->group($this->group, 'group', $new);
		$this->group = $new;
	}

	public function set_privilege($new) {
		$this->CI->api->modify->group($this->group, 'privilege', $new);
		$this->privilege = $new;
	}

	public function set_comment($new) {
		$this->CI->api->modify->group($this->group, 'comment', $new);
		$this->comment= $new;
	}
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC FUNCTIONS

}
/* End of file CurrentUser.php */
/* Location: ./application/libraries/objects/CurrentUser.php */
