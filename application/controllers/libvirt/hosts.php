<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Hosts extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Cloud");
		$this->_setSubHeader("Hosts");
		$this->_addTrail("Cloud","/libvirt");
		$this->_addTrail("Hosts","/libvirt/hosts/view/");
	}

	public function index() {
		$this->_sendClient("/libvirt/hosts/view/");
	}

	public function view() {
		// Instantiate
		try {
			$hs = $this->api->libvirt->get->hosts($this->user->getActiveUser());
		}
		catch(ObjectNotFoundException $e) { $hs = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Actions
		$this->_addAction("Create","/libvirt/hosts/create/");

		// Sidebar
		$this->_addSidebarHeader("HOSTS");

		foreach($hs as $h) {
			$this->_addSidebarItem($h->get_system_name(),"/libvirt/host/view/".rawurlencode($h->get_system_name()),"inbox");
		}

		// Viewdata

		// Content
		$content = $this->load->view('host/information',null,true);

		// Render
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$h = $this->api->libvirt->create->host(
					$this->_post('system_name'),
					$this->_post('uri'),
					$this->_post('password')
				);
				$this->_sendClient("/libvirt/host/view/".rawurlencode($h->get_system_name()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		try {
			$systems = $this->api->systems->get->systemsByType('VM Host');
		}
		catch(ObjectNotFoundException $e) {
			$this->_exit(new Exception("No VM hosts configured. You must configure at least one system to be a VM host before attempting to create a libvirt connection"));
		}
		catch(Exception $e) { $this->_exit($e); return; }

		$viewData['systems'] = $systems;

		$content = $this->load->view('host/create',$viewData,true);

		$this->_render($content);
	}
}

/* End of file hosts.php */
/* Location: ./application/controllers/libvirt/hosts.php */
