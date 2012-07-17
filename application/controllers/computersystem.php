<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class ComputerSystem extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("Systems");
		$this->_setSubHeader("Systems");
		$this->_addScript("/js/systems.js");
	}

	public function view($systemName=null)
	{
		// Decode
		$systemName = rawurldecode($systemName);

		// Instantiate
		try {
			$sys = $this->api->systems->get->systemByName($systemName);
			$p = $this->api->systems->get->platformByName($sys->get_platform());
		}
		catch(Exception $e) {
			$this->_exit($e);
			return;
		}

		// Breadcrumb trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail("$systemName","/system/view/".rawurlencode($systemName));

		// Actions
		$this->_addAction('Add Interface',"/interface/create/".rawurlencode($systemName),"success");
		$this->_addAction('Modify',"/system/modify/".rawurlencode($systemName));
		$this->_addAction('Remove',"/system/remove/".rawurlencode($systemName));

		// Generate content
		$content = $this->load->view('system/detail',array("sys"=>$sys,"p"=>$p),true);

		$intAddrs = array();
		$recs = array();

		$this->_addSidebarHeader("INTERFACES","/interfaces/view/".rawurlencode($sys->get_system_name()));
		try {
			$ints = $this->api->systems->get->interfacesBySystem($systemName);
			foreach($ints as $int) {
				$this->_addSidebarItem($int->get_mac(),"/interface/view/".rawurlencode($int->get_mac()),"road");
				try {
					$intAddrs = array_merge($intAddrs, $this->api->systems->get->interfaceaddressesByMac($int->get_mac()));
				}
				catch (ObjectNotFoundException $e) {}
				catch (Exception $e) {
					$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
					$this->_render($content);
					return;
				}
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) {
			$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
			$this->_render($content);
			return;
		}
		$this->_addSidebarHeader("ADDRESSES");
		foreach($intAddrs as $intAddr) {
			$this->_addSidebarItem($intAddr->get_address(),"/address/view/".rawurlencode($intAddr->get_address()),"globe");
			try {
				$recs = array_merge($recs, $this->api->dns->get->recordsByAddress($intAddr->get_address()));
			}
			catch (Exception $e) {
				$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
				$this->_render($content);
				return;
			}
		}

		$this->_addSidebarHeader("DNS RECORDS");
		$this->_addSidebarDnsRecords($recs);

		// Render page
		$this->_render($content);
	}

	public function create() {
		if($this->input->post()) {
			try {
				$sys = $this->api->systems->create->system(
					$this->input->post('systemName'),
					$this->input->post('owner'),
					$this->input->post('type'),
					$this->input->post('osName'),
					$this->input->post('comment'),
					$this->input->post('group'),
					$this->input->post('platform'),
					$this->input->post('asset'),
					$this->input->post('datacenter')
				);
				$this->_sendClient("/system/view/{$sys->get_system_name()}");
			}
			catch(Exception $e) {
				$this->_error($e);
			}
		}
		else {
			// Breadcrumb trail
			$this->_addTrail("Systems","/systems/");

			// View data
			$viewData['sysTypes'] = $this->api->systems->get->types();
			$viewData['operatingSystems'] = $this->api->systems->get->operatingSystems();
			$viewData['owner'] = ($this->user->getActiveUser() == 'all') ? $this->user->get_user_name() : $this->user->getActiveUser();
			$viewData['isAdmin'] = $this->user->isAdmin();
			$viewData['platforms'] = $this->api->systems->get->platforms();
			$viewData['groups'] = $this->api->get->groups();
			try {
				$viewData['dcs'] = $this->api->systems->get->datacenters();
			}
			catch(ObjectNotFoundException $e) {
				$this->_exit(new Exception("No Datacenters configured! Configure at least one datacenter before attempting to create a system."));
				return;
			}
			catch(Exception $e) { $this->_exit($e); return; }
			$content=$this->load->view('system/create',$viewData,true);
			$content .= $this->forminfo;
			$this->_render($content);
		}
	}

	public function modify($systemName) {
		$systemName = rawurldecode($systemName);
		try {
			$sys = $this->api->systems->get->systemByName($systemName);
		}
		catch(Exception $e) { $this->_error($e); }

		if($this->input->post()) {
	          $err = array();
	
	          // Check for which field was modified
	          if($sys->get_system_name() != $this->input->post('systemName')) {
	               try { $sys->set_system_name($this->input->post('systemName')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_type() != $this->input->post('type')) {
	               try { $sys->set_type($this->input->post('type')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_os_name() != $this->input->post('osName')) {
	               try { $sys->set_os_name($this->input->post('osName')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_comment() != $this->input->post('comment')) {
	               try { $sys->set_comment($this->input->post('comment')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_owner() != $this->input->post('owner')) {
	               try { $sys->set_owner($this->input->post('owner')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_group() != $this->input->post('group')) {
	               try { $sys->set_group($this->input->post('group')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_datacenter() != $this->input->post('datacenter')) {
	               try { $sys->set_datacenter($this->input->post('datacenter')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_platform() != $this->input->post('platform')) {
	               try { $sys->set_platform($this->input->post('platform')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_asset() != $this->input->post('asset')) {
	               try { $sys->set_asset($this->input->post('asset')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	
	          if($err) {
	               $this->_error($err);
	          }
			else {
				$this->_sendClient("/system/view/{$sys->get_system_name()}");
			}
		}
		else {
			// Breadcrumb
			$this->_addTrail('Systems',"/systems");
			$this->_addTrail("$systemName","/system/view/".rawurlencode($systemName));

			// View data
			$viewData['sysTypes'] = $this->api->systems->get->types();
			$viewData['operatingSystems'] = $this->api->systems->get->operatingSystems();
			$viewData['owner'] = ($this->user->getActiveUser() == 'all') ? $this->user->get_user_name() : $this->user->getActiveUser();
			$viewData['isAdmin'] = $this->user->isAdmin();
			$viewData['platforms'] = $this->api->systems->get->platforms();
			$viewData['dcs'] = $this->api->systems->get->datacenters();
			$viewData['sys'] = $sys;
			$viewData['groups'] = $this->api->get->groups();

			// Content
			$content = $this->load->view('system/modify',$viewData,true);
			$content .= $this->forminfo;

			// Done
			$this->_render($content);
		}
	}

	public function remove($systemName) {
		$systemName = rawurldecode($systemName);
		if($this->input->post('confirm')) {
			try {
				$this->api->systems->remove->system($systemName);
				$this->_sendClient("/systems/view/{$this->user->getACtiveUser()}");
			}
			catch (Exception $e) {
				$content = $this->load->view('exceptions/exception',array('exception'=>$e),true);
			}
		}
		else {
			$this->_error(new Exception("No confirmation"));
		}
	}

	public function quickcreate() {
		if($this->input->post()) {
			try {
				$this->api->systems->create->quick(
					$this->_post('system_name'),
					$this->_post('mac'),
					$this->_post('address'),
					$this->_post('zone'),
					$this->_post('owner'),
					$this->_post('group'),
					$this->_post('config')
				);
				$this->_sendClient("/system/view/".rawurlencode($this->_post('system_name')));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$this->_setSubHeader("Quick Create");
		$this->_addTrail("Systems","/systems/view");
		$viewData['isAdmin'] = $this->user->isAdmin();
		$viewData['owner'] = $this->user->getActiveUser();
		$viewData['ranges'] = $this->api->ip->get->ranges();
		$viewData['configs'] = $this->api->dhcp->get->configtypes();
		$viewData['zones'] = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
		$content = $this->load->view('system/quick',$viewData,true);
		$content .= $this->forminfo;
		$this->_render($content);

	}
}

/* End of file systems.php */
/* Location: ./application/controllers/systems.php */
