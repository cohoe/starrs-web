<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Soa extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DNS");
		$this->_setSubHeader("Zones");
		$this->_addTrail("Zones","/dns/zones/");
	}

	public function index() {
		$this->_sendClient("/dns/zones/view/");
	}

	public function view($zone) {
		// Decode
		$zone = rawurldecode($zone);

		// Instantiate
		try {
			$soa = $this->api->dns->get->soa($zone);

			// Actions
			$this->_addAction("Modify","/dns/soa/modify/".rawurlencode($soa->get_zone()));
			$this->_addAction("Remove","/dns/soa/remove/".rawurlencode($soa->get_zone()));

			// Viewdata
			$viewData['soaRec'] = $soa;

			// Content
			$content = $this->load->view('dns/soa/detail',$viewData,true);
		}
		catch(ObjectNotFoundException $e) {
			$this->_addAction("Create","/dns/soa/create/".rawurlencode($zone));
			$content = $this->_renderException($e);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		try {
			$zs = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($zone,"/dns/zone/view/".rawurlencode($zone));
		$this->_addTrail("SOA","/dns/soa/view/".rawurlencode($zone));

		// Sidebar
		$this->_addSidebarHeader("ZONE SOA RECORDS");
		foreach($zs as $z) {
			if($z->get_zone() == $zone) {
				$this->_addSidebarItem($z->get_zone(),"/dns/soa/view/".rawurlencode($z->get_zone()),"list",1);
			} else {
				$this->_addSidebarItem($z->get_zone(),"/dns/soa/view/".rawurlencode($z->get_zone()),"list");
			}
		}

		// Render
		$this->_render($content);
	}

	public function remove($zone) {
		// Decode
		$zone = rawurldecode($zone);

		// Instantiate
		try {
			$soa = $this->api->dns->get->soa($zone);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->dns->remove->soa($soa->get_zone());
				$this->_sendClient("/dns/soa/view/".rawurlencode($soa->get_zone()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		} else {
			$this->_error(new Exception("no confirmation"));
			return;
		}
	}

	public function create($zone) {
		// Decode
		$zone = rawurldecode($zone);

		try {
			$soa = $this->api->dns->create->soa($zone);
			$this->_sendClient("/dns/soa/view/".rawurlencode($soa->get_zone()));
		}
		catch(Exception $e) { $this->_exit($e); return; }
	}

	public function modify($zone) {
	
		// Decode
		$zone = rawurldecode($zone);

		// Instantiate
		try {
			$soa = $this->api->dns->get->soa($zone);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();

			if($soa->get_nameserver() != $this->_post('nameserver')) {
                    try { $soa->set_nameserver($this->_post('nameserver')); }
                    catch (Exception $e) { $err[] = $e; }
               }
               if($soa->get_ttl() != $this->_post('ttl')) {
                    try { $soa->set_ttl($this->_post('ttl')); }
                    catch (Exception $e) { $err[] = $e; }
               }
               if($soa->get_contact() != $this->_post('contact')) {
                    try { $soa->set_contact($this->_post('contact')); }
                    catch (Exception $e) { $err[] = $e; }
               }
               if($soa->get_serial() != $this->_post('serial')) {
                    try { $soa->set_serial($this->_post('serial')); }
                    catch (Exception $e) { $err[] = $e; }
               }
               if($soa->get_refresh() != $this->_post('refresh')) {
                    try { $soa->set_refresh($this->_post('refresh')); }
                    catch (Exception $e) { $err[] = $e; }
			}
               if($soa->get_retry() != $this->_post('retry')) {
                    try { $soa->set_retry($this->_post('retry')); }
                    catch (Exception $e) { $err[] = $e; }
               }
               if($soa->get_expire() != $this->_post('expire')) {
                    try { $soa->set_expire($this->_post('expire')); }
                    catch (Exception $e) { $err[] = $e; }
               }
               if($soa->get_minimum() != $this->_post('minimum')) {
                    try { $soa->set_minimum($this->_post('minimum')); }
                    catch (Exception $e) { $err[] = $e; }
               }

			if($err) {
                    $this->_error($err); return;
               }
               $this->_sendClient("/dns/soa/view/".rawurlencode($soa->get_zone()));

		}

		// Trail
		$this->_addTrail($zone,"/dns/zone/view/".rawurlencode($zone));
		$this->_addTrail("SOA","/dns/soa/view/".rawurlencode($zone));

		$viewData['soa'] = $soa;

		$content = $this->load->view('dns/soa/modify',$viewData,true);
		$content .= $this->forminfo;

		$this->_render($content);
	}
}

/* End of file soa.php */
/* Location: ./application/controllers/dns/soa.php */
