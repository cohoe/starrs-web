<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Current user class. Contains information about the user currently
 * initialized in the database
 */
class User {

	////////////////////////////////////////////////////////////////////////
	// CI OUTSIDE WORLD

	protected $CI;

	// MEMBER VARIABLES

	// The username of the current user passed in through Webauth
	private $userName;

	// The display name of the current user passed in through Webauth
	private $displayName;

	// The privilege level as determined by STARRS
	private $userLevel;

	// The user that you are viewing
	private $viewUser;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	/**
	 * Creates a new CurrentUser class using the given values. This should 
	 * never be done manually, always automatically
	 * @param	string	$userName	The name of the current user
	 * @param	string	$displayName	The display name of the current user
	 * @param	string	$userlevel	The privilege level
	 */
	public function __construct($userName, $displayName, $userLevel, $viewUser) {
		$this->userName = $userName;
		$this->displayName = $displayName;
		$this->userLevel = $userLevel;
		$this->viewUser = $viewUser;
		$this->CI =& get_instance();
		$this->viewMode = $this->CI->impulselib->getViewMode();
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_user_name()		{ return $this->userName; }
	public function get_display_name()	{ return $this->displayName; }
	public function get_user_level()	{ return $this->userLevel; }
	public function get_view_user()    { return $this->viewUser; }
	public function get_view_mode()    { return $this->viewMode; }

	////////////////////////////////////////////////////////////////////////
	// PUBLIC FUNCTIONS

	public function isadmin() {
		if(preg_match("/^ADMIN$/",$this->userLevel)) {
			return TRUE;
		}
		else {
			return NULL;
		}
	}

	public function getActiveUser() {
		if(!$this->viewUser) {
			return $this->userName;
		}
		else {
			return $this->viewUser;
		}
	}
}
/* End of file CurrentUser.php */
/* Location: ./application/libraries/objects/CurrentUser.php */
