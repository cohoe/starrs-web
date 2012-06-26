<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Records extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DNS");
	}

	public function view($address) {
		// Decode
		$address = rawurldecode($address);

		// Instantiate
		try {
			$intAddr = $this->api->systems->get->interfaceaddressByAddress($address);
		}
		catch (Exception $e) { $this->_exit($e); return; }

		// Trail
		// Actions
		$this->_addAction("Create","#");
		// Content
		try {
			$recs = $this->api->dns->get->recordsByAddress($intAddr->get_address());

			foreach($recs as $rec) {
			}
		}
		catch (ObjectNotFoundException $e) { $content = "None"; }
		catch (Exception $e) { $this->_exit($e); return; }

		$content = $this->load->view('dns/recordstable',null,true);

		// Sidebar
		$this->_addSidebarHeader("SYSTEM");

		// Render
		$this->_render($content);
	}
}

/* End of file records.php */
/* Location: ./application/controllers/dns/records.php */
