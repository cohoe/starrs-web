<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Group_settings extends ImpulseController {

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

	public function create($group) {

		$group = rawurldecode($group);
		$g = $this->api->get->group($group);

		if($this->input->post()) {
			try {
				$gset = $this->api->create->group_settings(
					$this->_post('group'),
					$this->_post('privilege'),
					$this->_post('provider'),
					$this->_post('hostname'),
					$this->_post('id'),
					$this->_post('username'),
					$this->_post('password')
				);

				$this->api->reload_group_members($gset->get_group());
				$this->_sendClient("/group/view/".rawurlencode($gset->get_group()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$this->_addTrail(htmlentities($g->get_group()),"/groups/view/".rawurlencode($g->get_group()));

		$viewData['g'] = $g;
		$content = $this->load->view('group_settings/create',$viewData,true);
		$content .= $this->forminfo;

		$this->_render($content);
	}

	public function modify($group) {
		// Decode
		$group = rawurldecode($group);

		// Instantiate
		try {
			$g = $this->api->get->group($group);
			$gset = $this->api->get->group_settings($group);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();
			if($gset->get_group() != $this->_post('group')) {
				try { $gset->set_group($this->_post('group')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($gset->get_privilege() != $this->_post('privilege')) {
				try { $gset->set_privilege($this->_post('privilege')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($gset->get_provider() != $this->_post('provider')) {
				try { $gset->set_provider($this->_post('provider')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($gset->get_hostname() != $this->_post('hostname')) {
				try { $gset->set_hostname($this->_post('hostname')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($gset->get_id() != $this->_post('id')) {
				try { $gset->set_id($this->_post('id')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($gset->get_username() != $this->_post('username')) {
				try { $gset->set_username($this->_post('username')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($gset->get_password() != $this->_post('password')) {
				try { $gset->set_password($this->_post('password')); }
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
		$viewData['gset'] = $gset;

		$content = $this->load->view('group_settings/modify',$viewData,true);
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

			try {
				$this->api->remove->group_settings($g->get_group());
				$this->_sendClient("/group/view/".rawurlencode($g->get_group()));
			}
			catch(Exception $e)  { $this->_error($e); return; }
	}
}

/* End of file groupcontroller.php */
/* Location: ./application/controllers/groupcontroller.php */
