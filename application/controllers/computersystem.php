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
		catch(ObjectNotFoundException $e) {
			$content = $this->_renderException($e);
			$this->_addAction("Create","/system/create/".rawurlencode($systemName));
			$this->_sidebarBlank();
			$this->_render($content);
			return;
		}
		catch(Exception $e) {
			$this->_exit($e);
			return;
		}

		// Breadcrumb trail
		$this->_addTrail('Systems',"/systems");
		$this->_addTrail("$systemName","/system/view/".rawurlencode($systemName));

		// Actions
		if($sys->get_type() == 'Virtual Machine') {
			try {
				$hs = $this->api->libvirt->get->hosts($this->user->getActiveUser());
				foreach($hs as $h) {
					try {
						$doms = $this->api->libvirt->get->domainsByHost($h->get_system_Name());
						foreach($doms as $dom) {
							if($dom->get_system_name() == $sys->get_system_name()) {
								$this->_addAction("Manage","/libvirt/domain/view/".rawurlencode($dom->get_host_name())."/".rawurlencode($sys->get_system_name()),"primary");
								break;
							}
						}
					}
					catch(ObjectNotFoundException $e) {}
					catch(Exception $e) { $this->_error($e); return; }
				}
			}
			catch(ObjectNotFoundException $e) {}
			catch(Exception $e) { $this->_error($e); return; }
		}
		$this->_addAction('Add Interface',"/interface/create/".rawurlencode($systemName),"success");
		if($sys->get_family() == 'Network') {
			$this->_addAction("CAM Table","/network/cam/view/".rawurlencode($systemName));
			$this->_addAction("SNMP","/network/snmp/view/".rawurlencode($systemName));
			$this->_addAction("Switchports","/network/switchports/view/".rawurlencode($sys->get_system_name()));
		}
		$this->_addAction('Modify',"/system/modify/".rawurlencode($systemName));
		$this->_addAction('Remove',"/system/remove/".rawurlencode($systemName));

		// Generate content
		$content = $this->loadview('system/detail',array("sys"=>$sys,"p"=>$p),true);

		$intAddrs = array();
		$recs = array();

		$this->_addSidebarHeader("INTERFACES","/interfaces/view/".rawurlencode($sys->get_system_name()));
		try {
			$ints = $this->api->systems->get->interfacesBySystem($systemName);
			foreach($ints as $int) {
				$this->_addSidebarItem($int->get_name()." (".$int->get_mac().")","/interface/view/".rawurlencode($int->get_mac()),"road");
				try {
					$intAddrs = array_merge($intAddrs, $this->api->systems->get->interfaceaddressesByMac($int->get_mac()));
				}
				catch (ObjectNotFoundException $e) {}
				catch (Exception $e) {
					$content = $this->loadview('exceptions/exception',array('exception'=>$e),true);
					$this->_render($content);
					return;
				}
			}
		}
		catch (ObjectNotFoundException $e) {}
		catch (Exception $e) {
			$content = $this->loadview('exceptions/exception',array('exception'=>$e),true);
			$this->_render($content);
			return;
		}
		$this->_addSidebarHeader("ADDRESSES");
		foreach($intAddrs as $intAddr) {
			$int = $this->api->systems->get->interfaceByMac($intAddr->get_mac());
			$this->_addSidebarItem($intAddr->get_address()." (".$int->get_name().")","/address/view/".rawurlencode($intAddr->get_address()),"globe");
			try {
				$recs = array_merge($recs, $this->api->dns->get->recordsByAddress($intAddr->get_address()));
			}
			catch (Exception $e) {
				$content = $this->loadview('exceptions/exception',array('exception'=>$e),true);
				$this->_render($content);
				return;
			}
		}

		$this->_addSidebarHeader("DNS RECORDS");
		$this->_addSidebarDnsRecords($recs);

		if($sys->get_type() == 'VM Host') {
			$this->_addSidebarHeader("DOMAINS","/libvirt/host/view/".rawurlencode($sys->get_system_name()));
			try {
				$doms = $this->api->libvirt->get->domainsByHost($sys->get_system_name());
			}
			catch(ObjectNotFoundException $e) { $doms = array(); }
			catch(Exception $e) { $this->_exit($e); return; }
			foreach($doms as $dom) {
				$this->_addSidebarItem($dom->get_system_name(), "/system/view/".rawurlencode($dom->get_system_name()), "hdd");
			}
		}

		// Render page
		$this->_render($content);
	}

	public function create($systemName=null) {
		// Decode
		$systemName = rawurldecode($systemName);

		if($this->input->post()) {
			try {
				$sys = $this->api->systems->create->system(
					$this->_post('systemName'),
					$this->_post('owner'),
					$this->_post('type'),
					$this->_post('osName'),
					$this->_post('comment'),
					$this->_post('group'),
					$this->_post('platform'),
					$this->_post('asset'),
					$this->_post('datacenter')
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
			$viewData['name'] = $systemName;
			$viewData['sysTypes'] = $this->api->systems->get->types();
			$viewData['operatingSystems'] = $this->api->systems->get->operatingSystems();
			$viewData['user'] = $this->user;
			$viewData['platforms'] = $this->api->systems->get->platforms();
			$viewData['groups'] = $this->api->get->groups();
			if($this->user->isadmin()) {
				$viewData['default_group'] = $this->api->get->group($this->api->get->site_configuration('DEFAULT_LOCAL_ADMIN_GROUP'))->get_group();
			} else {
				$viewData['default_group'] = $this->api->get->group($this->api->get->site_configuration('DEFAULT_LOCAL_USER_GROUP'))->get_group();
			}
			try {
				$viewData['dcs'] = $this->api->systems->get->datacenters();
			}
			catch(ObjectNotFoundException $e) {
				$this->_exit(new Exception("No Datacenters configured! Configure at least one datacenter before attempting to create a system."));
				return;
			}
			catch(Exception $e) { $this->_exit($e); return; }
			$content=$this->loadview('system/create',$viewData,true);
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
	          if($sys->get_system_name() != $this->_post('systemName')) {
	               try { $sys->set_system_name($this->_post('systemName')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_type() != $this->_post('type')) {
	               try { $sys->set_type($this->_post('type')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_os_name() != $this->_post('osName')) {
	               try { $sys->set_os_name($this->_post('osName')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_comment() != $this->_post('comment')) {
	               try { $sys->set_comment($this->_post('comment')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_owner() != $this->_post('owner')) {
	               try { $sys->set_owner($this->_post('owner')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_group() != $this->_post('group')) {
	               try { $sys->set_group($this->_post('group')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_datacenter() != $this->_post('datacenter')) {
	               try { $sys->set_datacenter($this->_post('datacenter')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_platform() != $this->_post('platform')) {
	               try { $sys->set_platform($this->_post('platform')); }
	               catch (Exception $e) { $err[] = $e; }
	          }
	          if($sys->get_asset() != $this->_post('asset')) {
	               try { $sys->set_asset($this->_post('asset')); }
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
			$content = $this->loadview('system/modify',$viewData,true);
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
				return;
			}
			catch (Exception $e) {
				$this->_error($e);
				return;
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
		$viewData['user'] = $this->user;
		try {
			$viewData['ranges'] = $this->api->ip->get->rangesByUser($this->user->getActiveUser());
		}
		catch(ObjectNotFoundException $e) { $viewData['ranges'] = array(); }
		catch(Exception $e) { $this->_exit($e); return; }
		$viewData['configs'] = $this->api->dhcp->get->configtypes();
		try {
			$viewData['zones'] = $this->api->dns->get->zonesByUser($this->user->getActiveUser());
		}
		catch(ObjectNotFoundException $e) { $viewData['zones'] = array(); }
		catch(Exception $e) { $this->_exit($e); return; }
		try {
			$viewData['groups'] = $this->api->get->groups();
		}
		catch(ObjectNotFoundException $e) { $this->_exit(new Exception("No groups found! Configure at least one group before attempting to create a system")); return; }
		catch(Exception $e) { $this->_exit($e); return; }
		if($this->user->isadmin()) {
			try {
				$viewData['default_group'] = $this->api->get->group($this->api->get->site_configuration('DEFAULT_LOCAL_ADMIN_GROUP'))->get_group();
			}
			catch(ObjectNotFoundException $e) { $viewData['default_group'] = null; }
			catch(Exception $e) { $this->_exit($e); return; }
		} else {
			try {
				$viewData['default_group'] = $this->api->get->group($this->api->get->site_configuration('DEFAULT_LOCAL_USER_GROUP'))->get_group();
			}
			catch(ObjectNotFoundException $e) { $viewData['default_group'] = null; }
			catch(Exception $e) { $this->_exit($e); return; }
		}
		$viewData['random'] = $this->api->get->site_configuration('ALLOW_RANDOM_MAC');
		$content = $this->loadview('system/quick',$viewData,true);
		$content .= $this->forminfo;
		$this->_render($content);

	}
}

/* End of file systems.php */
/* Location: ./application/controllers/systems.php */
