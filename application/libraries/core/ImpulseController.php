<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The replacement IMPULSE controller class. All controllers should extend from this rather than the builtin
 */
class ImpulseController extends CI_Controller {

	protected static $user;
	private $trail;
	private $sidebarItems;

	private $actions;
	private $navheader;
	private $contentList;

	private $js = array();

	public function __construct() {
		parent::__construct();
		
		// Initialize the database connection
		try {
			$this->api->initialize($this->impulselib->get_username());
		}
		catch(ObjectNotFoundException $onfE) {
			$this->_error("Unable to find your username (".$this->impulselib->get_username().") Make sure the LDAP server is functioning properly.");
		}
		catch(DBException $dbE) {
			$this->_error("Database connection error: ".$dbE->getMessage());
		}
		
		// Instantiate the user
		$this->user = new User(
			$this->impulselib->get_username(),
			$this->impulselib->get_name(),
			$this->api->get->current_user_level(),
			$this->input->cookie('impulse_viewUser',TRUE)
		);

		// Base JS
		$this->_addScript('/js/impulse.js');
	}

	public function index() {
		header("Location: /systems/view/".$this->user->getActiveUser());
	}

	protected function _render($content=null) {
		
		// Page title
		$title = "IMPULSE: ".ucfirst($this->uri->segment(1))."/".ucfirst($this->uri->segment(2));
	
		// Basic information about the user should be displayed
		$userData['userName'] = $this->user->get_user_name();
		$userData['displayName'] = $this->user->get_display_name();
		$userData['userLevel'] = $this->user->get_user_level();
		$userData['userLevel'] = $this->user->get_user_level();
		$userData['viewUser'] = $this->user->getActiveUser();
		$userData['header'] = $this->navheader;

		// If the user is an admin then they have the ability to easily switch "viewing" users
		if($this->user->isadmin()) {
			$userData['users'] = $this->api->get->users();
		}

		// Load navbar view
		$navbar = $this->load->view('core/navbar',$userData,true);

		// Load breadcrumb trail view
		$breadcrumb = $this->load->view('core/breadcrumb',array('segments'=>$this->trail),true);

		// Sidebar
		$sidebar = $this->load->view('core/sidebarblank',array('sideContent'=>$this->sidebarItems),true);

		// Content
		$content.= $this->_renderActions();

		// Error Handling
		$content .= $this->load->view('core/modalerror',null,true);

		// Confirmation
		$content .= $this->load->view('core/modalconfirm',null,true);

		// Info
		$content .= $this->load->view('core/modalinfo',null,true);

		// JS
		$scripts = "";
		foreach($this->js as $js) {
			$scripts .= "<script src=\"$js\"></script>";
		}

		// Send the data to the browser
		$this->load->view('core/main',array('title'=>$title,'navbar'=>$navbar,'breadcrumb'=>$breadcrumb,'sidebar'=>$sidebar,'content'=>$content,'scripts'=>$scripts));
	}

	protected function _addAction($action,$link,$class=null) {
		if(!$class) {
			switch($action) {
				case "Create":
					$class="success";
					break;
				case "Modify":
					$class="warning";
					break;
				case "Remove":
					$class="danger";
					break;
				default:
					$class="info";
					break;
			}
		}

		$id = strtolower(str_replace(" ",null,$action));

		$this->actions[] = $this->load->view('core/actionbutton',array("action"=>$action,"link"=>$link,"class"=>$class,"id"=>$id),true);
	}

	protected function _addTrail($name,$link) {
		$this->trail[$name] = $link;
	}

	protected function _renderActions() {
		if($this->actions) {
			$actionCode = "<div class=\"span2 well pull-right\">";
			foreach($this->actions as $action) {
				$actionCode .= $action;
			}
			$actionCode .= "</div>";
			return $actionCode;
		}
	}

	protected function _addSidebarItem($text, $link, $icon=null) {
		if($icon) {
			$this->sidebarItems .= "<li><a href=\"$link\"><i class=\"icon-$icon icon-black\"></i> $text</a></li>";
		}
		else {
			$this->sidebarItems .= "<li><a href=\"$link\">$text</a></li>";
		}
	}

	protected function _addSidebarHeader($text,$link=null) {
		if($link) {
			$this->sidebarItems .= "<li class=\"nav-header\"><a href=\"$link\">$text</a></li>";
		}	
		else {
			$this->sidebarItems .= "<li class=\"nav-header\">$text</li>";
		}
	}

	protected function _setNavHeader($header) {
		$this->navheader = $header;
	}

	protected function _sendClient($url,$return=null) {
		if(!$return) {
			print "<script>window.location.href = '$url';</script>";
		}
		else {
			return "<script>window.location.href = '$url';</script>";
		}
	}

	protected function _error($e) {
		$this->load->view('exceptions/modalerror',array('exception'=>$e));
	}

	protected function _addSidebarDnsRecords($recs) {
		foreach($recs as $rec) {
			switch(get_class($rec)) {
				case 'AddressRecord':
					$this->_addSidebarItem($rec->get_hostname().".".$rec->get_zone(),"/dns/records/view/".rawurlencode($rec->get_address())."#A/AAAA","font");
					break;
				case 'CnameRecord':
					$this->_addSidebarItem($rec->get_alias().".".$rec->get_zone(),"/dns/records/view/".rawurlencode($rec->get_address())."#CNAME","hand-right");
					break;
				case 'MxRecord':
					$this->_addSidebarItem($rec->get_hostname().".".$rec->get_zone(),"/dns/records/view/".rawurlencode($rec->get_address()),"#MX","envelope");
					break;
				case 'SrvRecord':
					$this->_addSidebarItem($rec->get_alias().".".$rec->get_zone(),"/dns/records/view/".rawurlencode($rec->get_address())."#SRV","wrench");
					break;
				case 'TextRecord':
					$this->_addSidebarItem($rec->get_hostname().".".$rec->get_zone(),"/dns/records/view/".rawurlencode($rec->get_address())."#TXT","list-alt");
					break;
				case 'NsRecord':
					$this->_addSidebarItem($rec->get_nameserver(),"/dns/records/view/".rawurlencode($rec->get_address())."#NS","file");
					break;
				default:
					throw new Exception("WTF?");
					break;
			}
		}
	}

	protected function _exit($e) {
		$content = $this->load->view('exceptions/exception',array("exception"=>$e),true);
		$this->_render($content);
	}

	protected function _addContentToList($content, $cols) {
		$this->contentList[$cols][] = $content;
	}

	protected function _renderContentList($cols) {
		$content = "<div class=\"container span7\">";
		$rowCounter = 0;
		foreach($this->contentList[$cols] as $view) {
			if($rowCounter == 0) {
				$content .= "<div class=\"row-fluid\">";
			}
			elseif($rowCounter % $cols == 0) {
				$content .= "</div><div class=\"row-fluid\">";
			}
			$content .= $view;
			$rowCounter++;
		}

		$content .= "</div></div>";
		return $content;
	}

	protected function _renderDnsTable($recs, $header) {
		$counter = 0;
		$table = "<a name=\"$header\"></a>";
		$table .= "<table class=\"table table-striped table-bordered\">";
		switch($header) {
			case "A/AAAA":
				$table .= "<tr><td colspan=5><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Hostname</th><th>Zone</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $aRec) {
					if(get_class($aRec) != "AddressRecord") { continue; }
					$viewLink = "/dns/a/view/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$modifyLink = "/dns/a/modify/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$removeLink = "/dns/a/remove/".rawurlencode($aRec->get_zone())."/".rawurlencode($aRec->get_address());
					$table .= "<tr><td>{$aRec->get_hostname()}</td><td>{$aRec->get_zone()}</td><td>{$aRec->get_ttl()}</td><td>{$aRec->get_type()}</td><td><a href=\"$viewLink\"><button class=\"btn btn-info btn-mini\">Details</button></a> <a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
					$counter++;
				}
				break;
			case "CNAME":
				$table .= "<tr><td colspan=6><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Alias</th><th>Hostname</th><th>Zone</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $cRec) {
					if(get_class($cRec) != "CnameRecord") { continue; }
					$viewLink = "/dns/cname/view/".rawurlencode($cRec->get_zone())."/".rawurlencode($cRec->get_alias());
					$modifyLink = "/dns/cname/modify/".rawurlencode($cRec->get_zone())."/".rawurlencode($cRec->get_alias());
					$removeLink = "/dns/cname/remove/".rawurlencode($cRec->get_zone())."/".rawurlencode($cRec->get_alias());
					$table .= "<tr><td>{$cRec->get_alias()}</td><td>{$cRec->get_hostname()}</td><td>{$cRec->get_zone()}</td><td>{$cRec->get_ttl()}</td><td>{$cRec->get_type()}</td><td><a href=\"$viewLink\"><button class=\"btn btn-info btn-mini\">Details</button></a> <a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
					$counter++;
				}
				break;
			case "SRV":
				$table .= "<tr><td colspan=9><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Alias</th><th>Hostname</th><th>Zone</th><th>Priority</th><th>Weight</th><th>Port</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $sRec) {
					if(get_class($sRec) != "SrvRecord") { continue; }
					$viewLink = "/dns/srv/view/".rawurlencode($sRec->get_zone())."/".rawurlencode($sRec->get_alias())."/".$sRec->get_priority()."/".$sRec->get_weight()."/".$sRec->get_port();
					$modifyLink = "/dns/srv/modify/".rawurlencode($sRec->get_zone())."/".rawurlencode($sRec->get_alias())."/".$sRec->get_priority()."/".$sRec->get_weight()."/".$sRec->get_port();
					$removeLink = "/dns/srv/remove/".rawurlencode($sRec->get_zone())."/".rawurlencode($sRec->get_alias())."/".$sRec->get_priority()."/".$sRec->get_weight()."/".$sRec->get_port();
					$table .= "<tr><td>{$sRec->get_alias()}</td><td>{$sRec->get_hostname()}</td><td>{$sRec->get_zone()}</td><td>{$sRec->get_priority()}</td><td>{$sRec->get_weight()}</td><td>{$sRec->get_port()}</td><td>{$sRec->get_ttl()}</td><td>{$sRec->get_type()}</td><td><a href=\"$viewLink\"><button class=\"btn btn-info btn-mini\">Details</button></a> <a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
					$counter++;
				}
				break;
			case "TXT":
				$table .= "<tr><td colspan=6><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Hostname</th><th>Zone</th><th>Text</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $tRec) {
					if(get_class($tRec) != "TextRecord") { continue; }
					$viewLink = "/dns/text/view/".rawurlencode($tRec->get_zone())."/".rawurlencode($tRec->get_hostname())."/".rawurlencode($tRec->get_text());
					$modifyLink = "/dns/text/modify/".rawurlencode($tRec->get_zone())."/".rawurlencode($tRec->get_hostname())."/".rawurlencode($tRec->get_text());
					$removeLink = "/dns/text/remove/".rawurlencode($tRec->get_zone())."/".rawurlencode($tRec->get_hostname())."/".rawurlencode($tRec->get_text());
					$table .= "<tr><td>{$tRec->get_hostname()}</td><td>{$tRec->get_zone()}</td><td>{$tRec->get_text()}</td><td>{$tRec->get_ttl()}</td><td>{$tRec->get_type()}</td><td><a href=\"$viewLink\"><button class=\"btn btn-info btn-mini\">Details</button></a> <a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
					$counter++;
				}
				break;
			case "NS":
				$table .= "<tr><td colspan=5><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Nameserver</th><th>Zone</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $nRec) {
					if(get_class($nRec) != "NsRecord") { continue; }
					$viewLink = "/dns/ns/view/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$modifyLink = "/dns/ns/modify/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$removeLink = "/dns/ns/remove/".rawurlencode($nRec->get_zone())."/".rawurlencode($nRec->get_nameserver());
					$table .= "<tr><td>{$nRec->get_nameserver()}</td><td>{$nRec->get_zone()}</td><td>{$nRec->get_ttl()}</td><td>{$nRec->get_type()}</td><td><a href=\"$viewLink\"><button class=\"btn btn-info btn-mini\">Details</button></a> <a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
					$counter++;
				}
				break;
			case "MX":
				$table .= "<tr><td colspan=6><h3>$header</h3></td></tr>";
				$table .= "<tr><th>Hostname</th><th>Zone</th><th>Preference</th><th>TTL</th><th>Type</th><th>Actions</th></tr>";
				foreach($recs as $mRec) {
					if(get_class($mRec) != "MxRecord") { continue; }
					$viewLink = "/dns/mx/view/".rawurlencode($mRec->get_zone())."/".rawurlencode($mRec->get_hostname());
					$modifyLink = "/dns/mx/modify/".rawurlencode($mRec->get_zone())."/".rawurlencode($mRec->get_hostname());
					$removeLink = "/dns/mx/remove/".rawurlencode($mRec->get_zone())."/".rawurlencode($mRec->get_hostname());
					$table .= "<tr><td>{$mRec->get_hostname()}</td><td>{$mRec->get_zone()}</td><td>{$mRec->get_preference()}</td><td>{$mRec->get_ttl()}</td><td>{$mRec->get_type()}</td><td><a href=\"$viewLink\"><button class=\"btn btn-info btn-mini\">Details</button></a> <a href=\"$modifyLink\"><button class=\"btn btn-mini btn-warning\">Modify</button></a> <a href=\"$removeLink\"><button class=\"btn btn-mini btn-danger\">Remove</button></a></td></tr>";
					$counter++;
				}
				break;

		}

		$table .= "</table>";

		if($counter == 0) {
			return;
		}
		else {
			return $this->load->view('core/table',array("table"=>$table),true);
		}
	}

	protected function _addScript($path) {
		$this->js[] = $path;
	}

	protected function _renderSimple($content) {
		// JS
		foreach($this->js as $js) {
			$content .= "<script src=\"$js\"></script>";
		}

		$this->output->set_output($content);
	}

	protected function _postToNull($var) {
		if(!$this->input->post($var)) {
			return null;
		}
		elseif($this->input->post($var) == "") {
			return null;
		}
		else {
			return $this->input->post($var);
		}
	}

}
/* End of file ImpulseController.php */
/* Location: ./application/libraries/core/ImpulseController.php */
