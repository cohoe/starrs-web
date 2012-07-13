<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/DnsController.php");

class Key extends DnsController {

	public function __construct() {
		parent::__construct();
		$this->_setSubHeader("Keys");
		$this->_addTrail("Keys","/dns/keys");
	}

	public function index() {
		$this->_sendClient("/dns/keys");
	}

	public function view($key=null) {
		// Decode
		$key = rawurldecode($key);

		try {
			$keys = $this->api->dns->get->keysByUser($this->user->getActiveUser());
			foreach($keys as $k) {
				$this->_addSidebarItem($k->get_keyname(),"/dns/key/view/".rawurlencode($k->get_keyname()),"check");
				if($k->get_keyname() == $key) {
					// Actions
					$this->_addAction("Modify","/dns/key/modify/".rawurlencode($k->get_keyname()));
					$this->_addAction("Remove","/dns/key/remove/".rawurlencode($k->get_keyname()));

					// Breadcrumb
					$this->_addTrail($k->get_keyname(),"/dns/key/view/".rawurlencode($k->get_keyname()));
					$content = $this->load->view('dns/key/detail',array("key"=>$k),true);
				}
			}
		}	
		catch(Exception $e) { $this->_exit($e); return; }
		// Render
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$k = $this->api->dns->create->key(
					$this->input->post('keyname'),
					$this->input->post('key'),
					$this->input->post('owner'),
					$this->input->post('comment')
				);
				$this->_sendClient("/dns/key/view/".rawurlencode($k->get_keyname()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$viewData['owner'] = $this->user->getActiveUser();
		$viewData['isAdmin'] = $this->user->isAdmin();
		$content = $this->load->view('dns/key/create',$viewData,true);
		$this->_render($content);
	}

	public function modify($key) {
		// decode
		$key = rawurldecode($key);

		// Instantiate
		try {
			$k = $this->api->dns->get->keyByUserName($this->user->getActiveUser(),$key);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();
			if($k->get_keyname() != $this->input->post('keyname')) {
	               try { $k->set_keyname($this->input->post('keyname')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($k->get_key() != $this->input->post('key')) {
	               try { $k->set_key($this->input->post('key')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($k->get_comment() != $this->input->post('comment')) {
	               try { $k->set_comment($this->input->post('comment')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($k->get_owner() != $this->input->post('owner')) {
	               try { $k->set_owner($this->input->post('owner')); }
	               catch (Exception $e) { $err[] = $e; }
	          }

			if($err) {
				$this->_error($err);
				return;
			}
			$this->_sendClient("/dns/key/view/".rawurlencode($k->get_keyname()));
			return;
		}

		$viewData['key'] = $k;
		$viewData['isAdmin'] = $this->user->isAdmin();
		$content = $this->load->view('dns/key/modify',$viewData,true);
		$content .= $this->forminfo;
		$this->_render($content);
	}

	public function remove($key) {
		$key = rawurldecode($key);
		if($this->input->post('confirm')) {
			try {
				$this->api->dns->remove->key($key);
				$this->_sendClient("/dns/keys/view/");
			}
			catch(Exception $e) { $this->_error($e); }
		}
		else {
			$this->_error(new Exception("No confirmation"));
		}
	}
}
/* End of file key.php */
/* Location: ./application/controllers/dns/key.php */
