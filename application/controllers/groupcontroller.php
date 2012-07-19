<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Groupcontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Management");
		$this->_setSubHeader("Groups");
		$this->_addTrail("Groups","/groups");
		$this->_addScript("/js/ip.js");
	}

	public function index() {
		$this->_sendClient("/groups/view/");
	}

	public function view($group) {
		// Decode
		$group = rawurldecode($group);

		// Instantiate
		try {
			$g = $this->api->get->group($group);
			$gs = $this->api->get->groups();
		}
		catch(Exception $e) { $this->_exit($e); return; }

		try {
			$gms = $this->api->get->groupMembers($g->get_group());
		}
		catch(ObjectNotFoundException $e) { $gms = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($g->get_group(),"/group/view/".rawurlencode($g->get_group()));

		// Sidebar
		$this->_addSidebarHeader("GROUPS");
		foreach($gs as $gp) {
			if($gp->get_group() == $g->get_group()) {
				$this->_addSidebarItem($gp->get_group(),"/group/view/".rawurlencode($gp->get_group()),"book",1);
			} else {
				$this->_addSidebarItem($gp->get_group(),"/group/view/".rawurlencode($gp->get_group()),"book");
			}
		}

		// Actions
		$this->_addAction("Add User","/groupmember/create/".rawurlencode($g->get_group()),"success");
		$this->_addAction("Modify","/group/modify/".rawurlencode($g->get_group()));
		$this->_addAction("Remove","/group/remove/".rawurlencode($g->get_group()));

		// Viewdata
		$viewData['g'] = $g;
		$viewData['gms'] = $gms;

		// Content
		$content = $this->load->view('group/detail',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$g = $this->api->create->group(
					$this->_post('group'),
					$this->_post('privilege'),
					$this->_post('comment')
				);
				$this->_sendClient("/group/view/".rawurlencode($g->get_group()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$content = $this->load->view('group/create',null,true);
		$content .= $this->forminfo;

		$this->_render($content);
	}

	public function modify($group) {
		// Decode
		$group = rawurldecode($group);

		// Instantiate
		try {
			$g = $this->api->get->group($group);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();
			if($g->get_group() != $this->_post('group')) {
				try { $g->set_group($this->_post('group')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($g->get_privilege() != $this->_post('privilege')) {
				try { $g->set_privilege($this->_post('privilege')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($g->get_comment() != $this->_post('comment')) {
				try { $g->set_comment($this->_post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($e);
				return;
			}

			$this->_sendClient("/group/view/".rawurlencode($g->get_group()));
			return;
		}

		$viewData['g'] = $g;

		$content = $this->load->view('group/modify',$viewData,true);
		$content .= $this->forminfo;

		$this->_render($content);
	}

	public function remove($group) {
		// Decode
		$group = rawurldecode($group);

		// Instantiate
		try {
			$g = $this->api->get->group($group);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->remove->group($g->get_group());
				$this->_sendClient("/groups/view");
			}
			catch(Exception $e)  { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("No confirmation"));
			return;
		}
	}
}

/* End of file groupcontroller.php */
/* Location: ./application/controllers/groupcontroller.php */
