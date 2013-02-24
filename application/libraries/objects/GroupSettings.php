<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class GroupSettings extends ImpulseObject{

	private $group; 

	private $privilege;

	private $provider;

	private $hostname;

	private $id;

	private $username;

	private $password;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	/**
	 */
	public function __construct($group, $privilege, $provider, $hostname, $id, $username, $password, $dateCreated, $dateModified, $lastModifier) {
		parent::__construct($dateCreated, $dateModified, $lastModifier);

		$this->group = $group;
		$this->privilege = $privilege;
		$this->provider = $provider;
		$this->hostname = $hostname;
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_group()	     { return $this->group; }
	public function get_privilege()	{ return $this->privilege; }
	public function get_provider()      { return $this->provider; }
	public function get_hostname()      { return $this->hostname; }
	public function get_id()      { return $this->id; }
	public function get_username()      { return $this->username; }
	public function get_password()      { return $this->password; }

	////////////////////////////////////////////////////////////////////////
	// SETTERS

	public function set_group($new) {
		$this->CI->api->modify->group_settings($this->group, 'group', $new);
		$this->group = $new;
	}

	public function set_privilege($new) {
		$this->CI->api->modify->group_settings($this->group, 'privilege', $new);
		$this->privilege = $new;
	}

	public function set_provider($new) {
		$this->CI->api->modify->group_settings($this->group, 'provider', $new);
		$this->provider = $new;
	}

	public function set_id($new) {
		$this->CI->api->modify->group_settings($this->group, 'id', $new);
		$this->id = $new;
	}

	public function set_hostname($new) {
		$this->CI->api->modify->group_settings($this->group, 'hostname', $new);
		$this->hostname = $new;
	}

	public function set_username($new) {
		$this->CI->api->modify->group_settings($this->group, 'username', $new);
		$this->username = $new;
	}

	public function set_password($new) {
		$this->CI->api->modify->group_settings($this->group, 'password', $new);
		$this->password = $new;
	}
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC FUNCTIONS

}
/* End of file CurrentUser.php */
/* Location: ./application/libraries/objects/CurrentUser.php */
