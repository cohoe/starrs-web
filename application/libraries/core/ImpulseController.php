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

		// Send the data to the browser
		$this->load->view('core/main',array('title'=>$title,'navbar'=>$navbar,'breadcrumb'=>$breadcrumb,'sidebar'=>$sidebar,'content'=>$content));
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

	protected function _sendClient($url) {
		print "<script>window.location.href = '$url';</script>";
	}

	protected function _error($e) {
		$this->load->view('exceptions/modalerror',array('exception'=>$e));
	}

	protected function _addSidebarDnsRecords($recs) {
		foreach($recs as $rec) {
			switch(get_class($rec)) {
				case 'AddressRecord':
					$this->_addSidebarItem($rec->get_hostname().".".$rec->get_zone(),"#","font");
					break;
				case 'CnameRecord':
					$this->_addSidebarItem($rec->get_alias().".".$rec->get_zone(),"#","hand-right");
					break;
				case 'MxRecord':
					$this->_addSidebarItem($rec->get_hostname().".".$rec->get_zone(),"#","envelope");
					break;
				case 'SrvRecord':
					$this->_addSidebarItem($rec->get_alias().".".$rec->get_zone(),"#","wrench");
					break;
				case 'TextRecord':
					$this->_addSidebarItem($rec->get_hostname().".".$rec->get_zone(),"#","list-alt");
					break;
				case 'NsRecord':
					$this->_addSidebarItem($rec->get_nameserver(),"#","file");
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
}
/* End of file ImpulseController.php */
/* Location: ./application/libraries/core/ImpulseController.php */
