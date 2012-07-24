<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Groupmembercontroller extends ImpulseController {

	public function view($group, $user) {
		// Decode
		$group = rawurldecode($group);
		$user = rawurldecode($user);

		// Instantiate
		try {
			$gm = $this->api->get->groupMember($group, $user);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Content
		$content = $this->load->view('groupmember/detail',array('gm'=>$gm),true);

		// Render
		$this->_renderSimple($content);
	}

	public function create($group) {
		// Decode
		$group = rawurldecode($group);

		// Instantiate
		try {
			$g = $this->api->get->group($group);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			try {
				$gm = $this->api->create->groupMember(
					$this->_post('group'),
					$this->_post('user'),
					$this->_post('privilege')
				);
				$this->_sendClient("/group/view/".rawurlencode($gm->get_group()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$content = $this->load->view('groupmember/create',array('g'=>$g),true);
		$this->_renderSimple($content);
	}

	public function modify($group, $user) {
		// Decode
		$group = rawurldecode($group);
		$user = rawurldecode($user);

		// Instantiate
		try {
			$gm = $this->api->get->groupMember($group, $user);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();
			if($gm->get_group() != $this->_post('group')) {
				try { $gm->set_group($this->_post('group')); }
				catch(Exception $e) { $err[] = $e; }
			}
			if($gm->get_user() != $this->_post('user')) {
				try { $gm->set_user($this->_post('user')); }
				catch(Exception $e) { $err[] = $e; }
			}
			if($gm->get_privilege() != $this->_post('privilege')) {
				try { $gm->set_privilege($this->_post('privilege')); }
				catch(Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err); return;
			}

			$this->_sendClient("/group/view/".rawurlencode($gm->get_group()));
			return;
		}

		$content = $this->load->view('groupmember/modify',array('gm'=>$gm),true);
		$this->_renderSimple($content);
	}
	
	public function remove($group, $user) {
		// Decode
		$group = rawurldecode($group);
		$user = rawurldecode($user);

		// Instantiate
		try {
			$gm = $this->api->get->groupMember($group, $user);
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->remove->groupMember($gm->get_group(),$gm->get_user());
				$this->_sendClient("/group/view/".rawurlencode($gm->get_group()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("no confirmation"));
			return;
		}
	}
}

/* End of file groupmembercontroller.php */
/* Location: ./application/controllers/groupmembercontroller.php */
