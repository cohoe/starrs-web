<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The replacement IMPULSE controller class. All controllers should extend from this rather than the builtin
 */
class ImpulseController extends CI_Controller {

	protected static $current_user;

	public function __construct() {
		parent::__construct();
		
		// Initialize the database connection
		try {
			$this->api->initialize($this->impulselib->get_username());
		}
		catch(ObjectNotFoundException $onfE) {
			$this->_error("Unable to find your username (".$this->impulselib->get_username().") Make sure the LDAP server is functioning properly.");
		}
		catch(DBException $dbE) {
			$this->_error("Database connection error: ".$dbE->getMessage());
		}
		
		// Instantiate the user
		$this->current_user = new CurrentUser(
			$this->impulselib->get_username(),
			$this->impulselib->get_name(),
			$this->api->get->current_user_level()
		);
	}

	protected function _render($sidebar,$content) {
		
		// Page title
		$title = "IMPULSE: ".ucfirst($this->uri->segment(1))."/".ucfirst($this->uri->segment(2));
	
		// Basic information about the user should be displayed
		$userData['userName'] = $this->current_user->get_user_name();
		$userData['displayName'] = $this->current_user->get_display_name();
		$userData['userLevel'] = $this->current_user->get_user_level();

		// If the user is an admin then they have the ability to easily switch "viewing" users
		if($this->current_user->isadmin()) {
			$userData['users'] = $this->api->get->users();
		}

		// Load navbar view
		$navbar = $this->load->view('core/navbar',$userData,true);

		// Load breadcrumb trail view
		$breadcrumb = $this->load->view('core/breadcrumb',array('segments'=>$this->uri->rsegment_array()),true);

		// Send the data to the browser
		$this->load->view('core/main',array('title'=>$title,'navbar'=>$navbar,'breadcrumb'=>$breadcrumb,'sidebar'=>$sidebar,'content'=>$content));
	}
}
/* End of file ImpulseController.php */
/* Location: ./application/libraries/core/ImpulseController.php */
