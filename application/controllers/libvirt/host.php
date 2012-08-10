<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Host extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Cloud");
		$this->_setSubHeader("Hosts");
		$this->_addTrail("Libvirt","/libvirt");
		$this->_addTrail("Hosts","/libvirt/hosts/view/");
	}

	public function index() {
		$this->_sendClient("/libvirt/hosts/view/");
	}

	public function view($host) {
		// Decode
		$host = rawurldecode($host);

		// Instantiate
		try {
			$h = $this->api->libvirt->get->host($host,$this->user->getActiveUser());
		}
		catch(Exception $e) { $this->_exit($e); return; }

		try {
			$doms = $this->api->libvirt->get->domainsByHost($h->get_system_name());
		}
		catch(ObjectNotFoundException $e) { $doms = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($h->get_system_name(),"/libvirt/host/view/".rawurlencode($h->get_system_name()));

		// Actions
		$this->_addAction("Modify","#");
		$this->_addAction("Remove","#");

		// Sidebar
		$this->_addSidebarHeader("DOMAINS");
		foreach($doms as $dom) {
			$this->_addSidebarItem($dom->get_system_name(), "/system/view/".rawurlencode($dom->get_system_name()), "hdd");
		}

		// Viewdata
		$viewData['h'] = $h;

		// Content
		$content = $this->load->view('host/detail',$viewData,true);

		// Render
		$this->_render($content);
	}
}
/* End of file host.php */
/* Location: ./application/controllers/libvirt/host.php */
