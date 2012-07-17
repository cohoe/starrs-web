<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class GroupMember extends ImpulseObject{

	private $group; 

	private $user;

	private $privilege;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	/**
	 */
	public function __construct($group, $user, $privilege, $dateCreated, $dateModified, $lastModifier) {
		parent::__construct($dateCreated, $dateModified, $lastModifier);

		$this->group = $group;
		$this->user = $user;
		$this->privilege = $privilege;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_group()	     { return $this->group; }
	public function get_privilege()	{ return $this->privilege; }
	public function get_user()      { return $this->user; }

	////////////////////////////////////////////////////////////////////////
	// GETTERS

	public function set_group($new) {
		$this->CI->api->modify->groupMember($this->group, $this->user, 'group', $new);
		$this->group = $new;
	}

	public function set_privilege($new) {
		$this->CI->api->modify->groupMember($this->group, $this->user, 'privilege', $new);
		$this->privilege = $new;
	}

	public function set_user($new) {
		$this->CI->api->modify->groupMember($this->group, $this->user, 'user', $new);
		$this->user= $new;
	}
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC FUNCTIONS

}
/* End of file GroupMember.php */
/* Location: ./application/libraries/objects/GroupMember.php */
