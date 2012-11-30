<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Users extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Management");
		$this->_setSubHeader("Users");
		$this->_addTrail("Users","#");
	}

	public function index() {
		$this->_sendClient("/users/view");
	}

	public function view($user=null) {
		$user = rawurldecode($user);

		if($user == null) {
			$this->_sendClient("/users/view/".rawurlencode($this->user->getActiveUser()));
		}
          try {
               $users = $this->api->get->users();
		}   
		catch(ObjectNotFoundException $e) { $users = array($this->user->getActiveUser()); }
          catch(Exception $e) {
               $content = $this->load->view('exceptions/exception',array("exception"=>$e),true);
          }   

		$this->_addAction("Remove","/users/remove/".rawurlencode($user),"danger");

		$this->_addSidebarHeader("USERS");
		foreach($users as $u) {
			if($user == $u) {
				$this->_addSidebarItem($u,"/users/view/".rawurlencode($u),"user",true);
			} else {
				$this->_addSidebarItem($u,"/users/view/".rawurlencode($u),"user");
			}
		}

		try {
			$viewData['groups'] = $this->api->get->userGroups($user);
		}
		catch(ObjectNotFoundException $e) { $viewData['groups'] = array(); }
		catch(Exception $e) { $this->_exit($e); }

		try {
			$viewData['systems'] = $this->api->systems->get->systemsByOwner($user);
		}
		catch(ObjectNotFoundException $e) { $viewData['systems'] = array(); }
		catch(Exception $e) { $this->_exit($e); }

		$viewData['user'] = $user;

		$content = $this->load->view('users',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function remove($user) {
		$user = rawurldecode($user);
		if($this->input->post('confirm')) {
               try {
				$systems = $this->api->systems->get->systemsByOwner($user);
				foreach($systems as $sys) {
                    	$this->api->systems->remove->system($sys->get_system_name());
				}
               }   
			catch(ObjectNotFoundException $e) {}
               catch (Exception $e) {
                    $this->_error($e);
                    return;
               }   
			try {
				$groups = $this->api->get->userGroups($user);
				foreach($groups as $g) {
					$this->api->remove->groupMember($g->get_group(), $user);
				}
			}
			catch(ObjectNotFoundException $e) {}
               catch (Exception $e) {
                    $this->_error($e);
                    return;
               }   
               $this->_sendClient("/users/view/{$this->user->getActiveUser()}");
          }   
          else {
               $this->_error(new Exception("No confirmation"));
          }   

	}

}

/* End of file users.php */
/* Location: ./application/controllers/users.php */
