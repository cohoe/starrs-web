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
			$dk = $this->api->dns->get->keyByUserName(null, $key);
		}
		catch(Exception $e) { $this->_error($e); return; }

		$this->_addSidebarHeader("KEYS");
		try { 
			if($this->user->getActiveUser() == 'all') { $uname = null; } else { $uname = $this->user->getActiveUser(); }
			$keys = $this->api->dns->get->keysByUser($uname);
			foreach($keys as $k) {
				if($k->get_keyname() == $key) {
					$this->_addSidebarItem($k->get_keyname(),"/dns/key/view/".rawurlencode($k->get_keyname()),"check",1);
				} else {
					$this->_addSidebarItem($k->get_keyname(),"/dns/key/view/".rawurlencode($k->get_keyname()),"check");
				}
			}
		}
		catch(ObjectNotFoundException $e) {}
		catch(Exception $e) { $this->_exit($e); return; }

		// Actions
		$this->_addAction("Modify","/dns/key/modify/".rawurlencode($dk->get_keyname()));
		$this->_addAction("Remove","/dns/key/remove/".rawurlencode($dk->get_keyname()));

		// Breadcrumb
		$this->_addTrail($dk->get_keyname(),"/dns/key/view/".rawurlencode($dk->get_keyname()));
		$content = $this->load->view('dns/key/detail',array("key"=>$dk),true);

		// Render
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$k = $this->api->dns->create->key(
					$this->_post('keyname'),
					$this->_post('key'),
					$this->_post('enctype'),
					$this->_post('owner'),
					$this->_post('comment')
				);
				$this->_sendClient("/dns/key/view/".rawurlencode($k->get_keyname()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$viewData['user'] = $this->user;
		$content = $this->load->view('dns/key/create',$viewData,true);
		$this->_render($content);
	}

	public function modify($key) {
		// decode
		$key = rawurldecode($key);

		// User stuff
		if($this->user->getActiveUser() == 'all') { $uname = null; } else { $uname = $this->user->getActiveUser(); }

		// Instantiate
		try {
			$k = $this->api->dns->get->keyByUserName($uname,$key);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();
			if($k->get_keyname() != $this->_post('keyname')) {
	               try { $k->set_keyname($this->_post('keyname')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($k->get_key() != $this->_post('key')) {
	               try { $k->set_key($this->_post('key')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($k->get_enctype() != $this->_post('enctype')) {
	               try { $k->set_enctype($this->_post('enctype')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($k->get_comment() != $this->_post('comment')) {
	               try { $k->set_comment($this->_post('comment')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($k->get_owner() != $this->_post('owner')) {
	               try { $k->set_owner($this->_post('owner')); }
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
