<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Configuration extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Management");
		$this->_setSubHeader("Configuration");
		$this->_addTrail("Configuration","/configuration/view");
		$this->_addScript("/js/config.js");
		if(!$this->user->isAdmin()) {
			$this->_exit(new Exception("Only admins can view configuration"));
			return;
		}
	}

	public function index() {
		$this->_sendClient("/configuration/view/");
	}

	public function view($config=null) {
		$config = rawurldecode($config);

		if($config != null) {
			try {
				$cfg = $this->api->get->siteconfig($config);
				$content = $this->load->view('configuration/detail',array('c'=>$cfg),true);
				$this->_renderSimple($content);
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		// Instantiate
		try {
			$confs = $this->api->get->site_configuration_all();
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Actions
		$this->_addAction("Create","/configuration/create/");

		// Viewdata
		$viewData['confs'] = $confs;

		// Sidebar
		$this->_sidebarBlank();

		// Content
		$content = $this->load->view('configuration/view',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$this->api->create->site_configuration(
					$this->_post('option'),
					$this->_post('value')
				);
				$this->_sendClient("/configuration/view/");
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$this->_renderSimple($this->load->view('configuration/create',null,true));
	}

	public function modify($config) {
		$config = rawurldecode($config);

		try {
			$cfg = $this->api->get->siteconfig($config);
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post()) {
			if($cfg->get_value() != $this->_post('value')) {
				try { $cfg->set_value($this->_post('value')); }
				catch (Exception $e) { $this->_error($e); return; }
			}

			$this->_sendClient("/configuration/view/");
		}
		
		$this->_renderSimple($this->load->view('configuration/modify',array('cfg'=>$cfg),true));

	}

	public function remove($config) {
		$config = rawurldecode($config);

		try {
			$cfg = $this->api->get->siteconfig($config);
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->remove->site_configuration($cfg->get_option());
			}
			catch(Exception $e) { $this->_error($e); return; }
			$this->_sendClient("/configuration/view");
		}
		else {
			$this->_error(new Exception("No confirmation"));
		}
	}
}

/* End of file configuration.php */
/* Location: ./application/controllers/configuration.php */
