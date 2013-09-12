<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Platformcontroller extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_setSubHeader("Platforms");
		$this->_addTrail("Platforms","/platforms/view/");
	}

	public function index() {
		$this->_sendClient("/platforms/view/");
	}

	public function view($platform) {
		// Decode
		$platform = rawurldecode($platform);

		// Instantiate
		try {
			$p = $this->api->systems->get->platformByName($platform);
			$ps = $this->api->systems->get->platforms();
		}
		catch(Exception $e) { $this->_exit($e); return; }
		try {
			#$lp = $this->api->libvirt->get->platform($platform);
		}
		catch(ObjectNotFoundException $e) { }
		catch(Exception $e) { $this->_exit($e); return; }

		// Trail
		$this->_addTrail($p->get_platform_name(),"/platform/view/".rawurlencode($p->get_platform_name()));

		// Actions
		#$this->_addAction("Define","/platform/define/".rawurlencode($p->get_platform_name()));
		$this->_addAction("Modify","/platform/modify/".rawurlencode($p->get_platform_name()));
		$this->_addAction("Remove","/platform/remove/".rawurlencode($p->get_platform_name()));

		// Sidebar
		$this->_addSidebarHeader("PLATFORMS");
		foreach($ps as $pla) {
			if($pla->get_platform_name() == $p->get_platform_name()) {
				$this->_addSidebarItem($pla->get_platform_name(),"/platform/view/".rawurlencode($pla->get_platform_name()),"share",1);
			} else {
				$this->_addSidebarItem($pla->get_platform_name(),"/platform/view/".rawurlencode($pla->get_platform_name()),"share");
			}
		}

		// Viewdata
		$viewData['p'] = $p;
		if(isset($lp)) {
			$viewData['lp'] = $lp;
		}

		// Content
		$content = $this->load->view('platform/detail',$viewData,true);

		// Render
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$p = $this->api->systems->create->platform(
					$this->_post('platform_name'),
					$this->_post('architecture'),
					$this->_post('disk'),
					$this->_post('cpu'),
					$this->input->post('memory')
				);
				$this->_sendClient("/platform/view/".rawurlencode($p->get_platform_name()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$viewData['architectures'] = $this->api->systems->get->architectures();

		$content = $this->load->view('platform/create',$viewData,true);
		$content .= $this->forminfo;

		$this->_render($content);
	}

	public function modify($platform) {
		// Decode
		$platform = rawurldecode($platform);

		// Instantiate
		try {
			$p = $this->api->systems->get->platformByName($platform);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();

			if($p->get_platform_name() != $this->_post('platform_name')) {
				try { $p->set_platform_name($this->_post('platform_name')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($p->get_architecture() != $this->_post('architecture')) {
				try { $p->set_architecture($this->_post('architecture')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($p->get_disk() != $this->_post('disk')) {
				try { $p->set_disk($this->_post('disk')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($p->get_cpu() != $this->_post('cpu')) {
				try { $p->set_cpu($this->_post('cpu')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($p->get_memory() != $this->input->post('memory')) {
				try { $p->set_memory($this->input->post('memory')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err); return;
			}

			$this->_sendClient("/platform/view/".rawurlencode($p->get_platform_name()));
			return;
		}

		$viewData['p'] = $p;
		$viewData['architectures'] = $this->api->systems->get->architectures();
		
		$content = $this->load->view('platform/modify',$viewData,true);

		$this->_render($content);
	}

	public function remove($platform) {
		// Decode
		$platform = rawurldecode($platform);

		// Instantiate
		try {
			$p = $this->api->systems->get->platformByName($platform);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->systems->remove->platform($p->get_platform_name());
				$this->_sendClient("/platforms/view/");
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		} else {
			$this->_error(new Exception("No confirmation"));
			return;
		}

	}

	public function define($platform) {
		// Decode
		$platform = rawurldecode($platform);

		// Instantiate
		try {
			$p = $this->api->systems->get->platformByName($platform);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			print $this->input->post('definition');
			return;
		}

		$viewData['p'] = $p;

		$content = $this->load->view('platform/define',$viewData,true);
		$content .= $this->forminfo;
		$this->_render($content);
	}
}

/* End of file platformcontroller.php */
/* Location: ./application/controllers/platformcontroller.php */
