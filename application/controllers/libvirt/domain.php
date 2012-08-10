<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Domain extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Libvirt");
		$this->_setSubHeader("Domain");
		$this->_addTrail("Libvirt","/libvirt/");

	}

	public function index() {
		$this->_sendClient("/libvirt/hosts/view/");
	}

	public function view($host,$systemName) {
		$this->_addScript("/js/power.js");
		// Decode
		$host = rawurldecode($host);
		$systemName = rawurldecode($systemName);

		// Instantiate
		try {
			$dom = $this->api->libvirt->get->domain($host,$systemName);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail("Hosts","/libvirt/hosts/view");
		$this->_addTrail($dom->get_host_name(),"/libvirt/host/view/".rawurlencode($dom->get_host_name()));
		$this->_addTrail("Domains","/libvirt/host/view/".rawurlencode($dom->get_host_name()));
		$this->_addTrail($dom->get_system_name(),"/libvirt/domain/view/".rawurlencode($dom->get_host_name())."/".rawurlencode($dom->get_system_name()));


		// Actions
		$this->_addAction("Console","#","primary");
		$this->_addAction("Power","/libvirt/domain/power/".rawurlencode($dom->get_host_name())."/".rawurlencode($dom->get_system_name()),"warning");
		$this->_addAction("Remove","#");

		// Sidebar
		$this->_addSidebarHeader("DOMAINS");

		// Viewdata
		$viewData['dom'] = $dom;

		// Content
		$content = $this->load->view('domain/detail',$viewData,true);
		$content .= $this->load->view('domain/modalcontrol',null,true);

		// Render
		$this->_render($content);
	}

	public function power($host,$systemName,$action=null) {
		// Decode
		$host = rawurldecode($host);
		$systemName = rawurldecode($systemName);

		// Instantiate
		try {
			$dom = $this->api->libvirt->get->domain($host,$systemName);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($action) {
			try {
				$dom->set_state($action);
				$this->_sendClient("/libvirt/domain/view/".rawurlencode($dom->get_host_name())."/".rawurlencode($dom->get_system_name()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}


		$viewData['dom'] = $dom;

		$content = $this->load->view('domain/power',$viewData,true);

		$this->_renderSimple($content);
	}
		
}

/* End of file template.php */
/* Location: ./application/controllers/template.php */
