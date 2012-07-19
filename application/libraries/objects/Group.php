<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class Group extends ImpulseObject{

	private $group; 

	private $privilege;

	private $comment;

	private $renew;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	/**
	 */
	public function __construct($group, $privilege, $comment, $renew, $dateCreated, $dateModified, $lastModifier) {
		parent::__construct($dateCreated, $dateModified, $lastModifier);

		$this->group = $group;
		$this->privilege = $privilege;
		$this->comment = $comment;
		$this->renew = $renew;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_group()	     { return $this->group; }
	public function get_privilege()	{ return $this->privilege; }
	public function get_comment()      { return $this->comment; }
	public function get_renew()      { return $this->renew; }

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

	public function set_renew($new) {
		$this->CI->api->modify->group($this->group, 'renew_interval', $new);
		$this->renew= $new;
	}
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC FUNCTIONS

}
/* End of file CurrentUser.php */
/* Location: ./application/libraries/objects/CurrentUser.php */
