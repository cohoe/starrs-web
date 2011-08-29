<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class SystemSearchResult {
	private $systemName;
	private $owner;
	private $lastModifier;
	
	public function __construct($systemName, $owner, $lastModifier) {
		$this->systemName = $systemName;
		$this->owner = $owner;
		$this->lastModifier = $lastModifier;
	}
	
	public function get_system_name() { return $this->systemName; }
	public function get_owner() { return $this->owner; }
	public function get_last_modifier() { return $this->lastModifier; }
}

class InterfaceSearchResult {
	private $mac;
	private $owner;
	private $lastModifier;
	
	public function __construct($mac, $owner, $lastModifier) {
		$this->interfaceName = $interfaceName;
		$this->owner = $owner;
		$this->lastModifier = $lastModifier;
	}
	
	public function get_mac() { return $this->mac; }
	public function get_owner() { return $this->owner; }
	public function get_last_modifier() { return $this->lastModifier; }
}

class Search extends ImpulseController {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		if($this->input->post('submit')) {
			try {
				$query = $this->api->search($this->input->post());
			}
			catch(Exception $e) {
				$this->_error($e->getMessage());
			}
			
			#$viewData['title'] = "Systems";
			#$viewData['data'] = $this->_warning("System view data!");
			#$systemData = $this->load->view('search/data',$viewData,TRUE);
			
			// $systems = array();
			// $interfaces = array();
			// foreach($query->result_array() as $result) {
				// $systems[$result['system_name']] = new SystemSearchResult(
					// $result['system_name'],
					// $result['system_owner'],
					// $result['system_last_modifier']
				// );
				// $interfaces[$result['mac']] = new InterfaceSearchResult(
					// $result['mac'],
					// $result['system_owner'],
					// $result['system_last_modifier']
				// );
			// }
			// $systemData = "<table><tr><th>System Name</th><th>Owner</th><th>Last Modifier</th></tr>";
			// foreach($systems as $system) {
				// $systemData .= "<tr><td>{$system->get_system_name()}</td><td>{$system->get_owner()}</td><td>{$system->get_last_modifier()}</td></tr>";
			// }
			// $systemData .= "</table>";
			
			// $systemData = $this->load->view('search/data',array("title"=>"Systems","data"=>$systemData),true);
			
			#$results[] = array(array_keys($query->first_row('array')));
			#system_name	mac	address	system_owner	system_last_modifier	range	hostname	zone	dns_owner	dns_last_modifier
			$results[] = array("System Name","MAC","Address","System Owner","System Last Modifier","Range","Hostname","Zone","DNS Owner","DNS Last Modifier");
			foreach($query->result_array() as $result) {
				$result['system_name'] = "<a href=\"/system/view/".rawurlencode($result['system_name'])."\">{$result['system_name']}</a>";
				$result['mac'] = "<a href=\"/interface/view/".rawurlencode($result['mac'])."\">{$result['mac']}</a>";
				$result['hostname'] = "<a href=\"/dns/view/".rawurlencode($result['address'])."\">{$result['hostname']}</a>";
				$result['address'] = "<a href=\"/address/view/".rawurlencode($result['address'])."\">{$result['address']}</a>";
				$result['zone'] = "<a href=\"/resources/zones/view/".rawurlencode($result['zone'])."\">{$result['zone']}</a>";
				$result['range'] = "<a href=\"/resources/ranges/view/".rawurlencode($result['range'])."\">{$result['range']}</a>";
				$results[] = $result;
			}
			$systemData = $this->table->generate($results);
			
			// Navbar
			$navbar = new Navbar("Search Results", null, null);
			
			// Load view data
			$info['header'] = $this->load->view('core/header',"",TRUE);
			$info['sidebar'] = $this->load->view('core/sidebar',array("sidebar"=>self::$sidebar),TRUE);
			$info['navbar'] = $this->load->view('core/navbar',array("navbar"=>$navbar),TRUE);
			$info['data'] = $systemData;
			$info['title'] = "Search Results";
			
			// Load the main view
			$this->load->view('core/main',$info);
		}
		else {
			// Navbar
			$navbar = new Navbar("Search", null, null);
			
			// Form data
			$formdata['ranges'] = $this->api->ip->get->ranges();
			$formdata['zones'] = $this->api->dns->get->zones(NULL);
			
			// Load view data
			$info['header'] = $this->load->view('core/header',"",TRUE);
			$info['sidebar'] = $this->load->view('core/sidebar',array("sidebar"=>self::$sidebar),TRUE);
			$info['navbar'] = $this->load->view('core/navbar',array("navbar"=>$navbar),TRUE);
			$info['data'] = $this->load->view('search/form',$formdata,TRUE);
			$info['title'] = "Search";
			
			// Load the main view
			$this->load->view('core/main',$info);
		}
	}
	
	public function test() {
		echo "Hi";
	}
}
/* End of file search.php */
/* Location: ./application/controllers/search.php */