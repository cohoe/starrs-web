<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Range extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("IP");
		$this->_setSubHeader("Ranges");
		$this->_addTrail("IP","/ip");
		$this->_addScript("/js/ip.js");
	}

	public function index() {
		$this->_sendClient("#");
	}

	public function view($range) {
		// Decode
		$range = rawurldecode($range);

		// Instantiate
		try {
			$r = $this->api->ip->get->range($range);
			$stat = $this->api->ip->get->rangeStatsByName($r->get_name());
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail("Subnets","/ip/subnets/");
		$this->_addTrail($r->get_subnet(),"/ip/subnet/view/".rawurlencode($r->get_subnet()));
		$this->_addTrail("Ranges","/ip/ranges/view/");
		$this->_addTrail($r->get_name(),"/ip/range/view/".rawurlencode($r->get_name()));

		// Actions
		$this->_addAction("Create DHCP Option","/dhcp/rangeoption/create/".rawurlencode($r->get_name()),"success");
		$this->_addAction("Modify","/ip/range/modify/".rawurlencode($r->get_name()));
		$this->_addAction("Remove","/ip/range/remove/".rawurlencode($r->get_name()));

		// Sidebar
		try {
			$rs = $this->api->ip->get->rangesBySubnet($r->get_subnet());
		}
		catch(ObjectNotFoundException $e) { $rs = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		$this->_addSidebarHeader("RANGES");
		foreach($rs as $rng) {
			if($rng->get_name() == $r->get_name()) {
				$this->_addSidebarItem($rng->get_name(),"/ip/range/view/".rawurlencode($rng->get_name()),"resize-full",1);
			} else {
				$this->_addSidebarItem($rng->get_name(),"/ip/range/view/".rawurlencode($rng->get_name()),"resize-full");
			}
		}

		// Options
		try {
			$opts = $this->api->dhcp->get->rangeoptions($r->get_name());
		}
		catch(ObjectNotFoundException $e) { $opts = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		// Content
		$content = "<div class=span7>";
		$content .= $this->load->view('ip/range/detail',array('r'=>$r,'stat'=>$stat),true);
		$content .= $this->_renderOptionView($opts);
		$content .= "</div>";

		// Render
		$this->_render($content);
	}
	
	public function create($subnet=null) {
		// Decode
		$subnet = rawurldecode($subnet);

		// Instantiate
		try {
			$snet = $this->api->ip->get->subnet($subnet);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			try {
				$r = $this->api->ip->create->range(
					$this->_post('name'),
					$this->_post('firstip'),
					$this->_post('lastip'),
					$subnet,
					$this->_post('use'),
					$this->_post('class'),
					$this->_post('comment'),
					$this->_post('datacenter'),
					$this->_post('zone')
				);

				$this->_sendClient("/ip/range/view/".rawurlencode($r->get_name()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		// Trail
		$this->_addTrail("Subnets","/ip/subnets/");
		$this->_addTrail($snet->get_subnet(),"/ip/subnet/view/".rawurlencode($snet->get_subnet()));
		$this->_addTrail("Ranges","/ip/ranges/view/");

		// Viewdata
		$viewData['snet'] = $snet;
		$viewData['uses'] = $this->api->ip->get->uses();
		try {
			$viewData['classes'] = $this->api->dhcp->get->classes();
		}
		catch(ObjectNotFoundException $e) { $this->_exit(new Exception("No DHCP classes configured! Set up at least one DHCP class before trying to create an IP range")); return; }
		catch(Exception $e) { $this->_exit($e); return; }
		try {
			$viewData['azs'] = $this->api->systems->get->availabilityzonesByDatacenter($snet->get_datacenter());
		}
		catch(ObjectNotFoundException $e) { $this->_exit(new Exception("No Availability Zones configured for your datacenter. Create an AZ before trying to create an IP range")); return; }
		catch(Exception $e) { $this->_exit($e); return; }

		// Content
		$content = $this->load->view('ip/range/create',$viewData,true);
		$content .= $this->forminfo;

		// Render
		$this->_render($content);
	}

	public function modify($range) {
		// Decode
		$range = rawurldecode($range);

		// Instantiate
		try {
			$r = $this->api->ip->get->range($range);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();
			if($r->get_name() != $this->_post('name')) {
				try { $r->set_name($this->_post('name')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($r->get_first_ip() != $this->_post('firstip')) {
				try { $r->set_first_ip($this->_post('firstip')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($r->get_last_ip() != $this->_post('lastip')) {
				try { $r->set_last_ip($this->_post('lastip')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($r->get_use() != $this->_post('use')) {
				try { $r->set_use($this->_post('use')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($r->get_class() != $this->_post('class')) {
				try { $r->set_class($this->_post('class')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($r->get_zone() != $this->_post('zone')) {
				try { $r->set_zone($this->_post('zone')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($r->get_comment() != $this->_post('comment')) {
				try { $r->set_comment($this->_post('comment')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
				return;
			}
			
			$this->_sendClient("/ip/range/view/".rawurlencode($r->get_name()));

		}

		// Trail
		$this->_addTrail("Subnets","/ip/subnets/");
		$this->_addTrail($r->get_subnet(),"/ip/subnet/view/".rawurlencode($r->get_subnet()));
		$this->_addTrail("Ranges","/ip/ranges/view/");

		// Viewdata
		$viewData['r'] = $r;
		$viewData['uses'] = $this->api->ip->get->uses();
		$viewData['classes'] = $this->api->dhcp->get->classes();
		$viewData['azs'] = $this->api->systems->get->availabilityzonesByDatacenter($r->get_datacenter());

		// Content
		$content = $this->load->view('ip/range/modify',$viewData,true);
		$content .= $this->forminfo;

		// Render
		$this->_render($content);
	}

	public function remove($range) {
		// Decode
		$range = rawurldecode($range);

		// Instantiate
		try {
			$r= $this->api->ip->get->range($range);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->ip->remove->range($r->get_name());
				$this->_sendClient("/ip/subnet/view/".rawurlencode($r->get_subnet()));
			}	
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("no confirmation"));
		}
	}
}

/* End of file range.php */
/* Location: ./application/controllers/range.php */
