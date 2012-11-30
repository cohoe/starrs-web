<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseModel.php");
require_once(APPPATH . "models/API/Management/api_management_create.php");
require_once(APPPATH . "models/API/Management/api_management_modify.php");
require_once(APPPATH . "models/API/Management/api_management_remove.php");
require_once(APPPATH . "models/API/Management/api_management_get.php");

/**
 * The STARRS API - the only supported way to interact with the STARRS database. 
 */
class Api extends ImpulseModel {

	public $dhcp;
	public $dns;
	public $ip;
	public $management;
	public $network;
	public $systems;
	public $libvirt;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	/**
	This class does database work. That is all. These functions are the
	only access to the database you get.
	*/
	public function __construct() {
		parent::__construct();
		$this->_load();
		$this->dhcp = new API_DHCP();
		$this->dns = new API_DNS();
		$this->ip = new API_IP();
		$this->management = new API_Management();
		$this->network = new API_Network();
		$this->systems = new API_Systems();
		$this->libvirt = new API_Libvirt();
		
		$this->create = new Api_management_create();
		$this->modify = new Api_management_modify();
		$this->remove = new Api_management_remove();
		$this->get = new Api_management_get();
	}

	////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS

	public function initialize($user) {
		// SQL Query
		$sql = "SELECT api.initialize({$this->db->escape($user)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
	}
	
	public function deinitialize() {
		// SQL Query
		$sql = "SELECT api.deinitialize()";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
	}
	
	public function search($searchArray) {
		// Build query string
		$searchString = "WHERE system_name IS NOT NULL ";
		if($searchArray['datacenter']) {
			if($searchArray['datacenter'] == 'null') {
				$searchString .= "AND datacenter IS NULL ";
			} else {
				$searchString .= "AND datacenter ~* {$this->db->escape($searchArray['datacenter'])} ";
			}
		}
		if($searchArray['systemName']) {
			if($searchArray['systemName'] == 'null') {
				$searchString .= "AND system_name IS NULL ";
			} else {
				$searchString .= "AND system_name ~* {$this->db->escape($searchArray['systemName'])} ";
			}
		}
		if($searchArray['asset']) {
			if($searchArray['asset'] == 'null') {
				$searchString .= "AND asset IS NULL ";
			} else {
				$searchString .= "AND asset ~* {$this->db->escape($searchArray['asset'])} ";
			}
		}
		if($searchArray['group']) {
			if($searchArray['group'] == 'null') {
				$searchString .= "AND group IS NULL ";
			} else {
				$searchString .= "AND \"group\" ~* {$this->db->escape($searchArray['group'])} ";
			}
		}
		if($searchArray['platform_name']) {
			if($searchArray['platform_name'] == 'null') {
				$searchString .= "AND platform IS NULL ";
			} else {
				$searchString .= "AND platform ~* {$this->db->escape($searchArray['platform_name'])} ";
			}
		}
		if($searchArray['availabilityzone']) {
			if($searchArray['availabilityzone'] == 'null') {
				$searchString .= "AND availability_zone IS NULL ";
			} else {
				$searchString .= "AND availability_zone ~* {$this->db->escape($searchArray['availabilityzone'])} ";
			}
		}
		if($searchArray['mac']) {
			if($searchArray['mac'] == 'null') {
				$searchString .= "AND mac IS NULL ";
			} else {
				$searchString .= "AND mac = {$this->db->escape($searchArray['mac'])} ";
			}
		}
		if($searchArray['ipaddress']) {
			if($searchArray['availabilityzone'] == 'null') {
				$searchString .= "AND address IS NULL ";
			} else {
				$searchString .= "AND address = {$this->db->escape($searchArray['ipaddress'])} ";
			}
		}
		if($searchArray['config']) {
			if($searchArray['config'] == 'null') {
				$searchString .= "AND config IS NULL ";
			} else {
				$searchString .= "AND config = {$this->db->escape($searchArray['config'])} ";
			}
		}
		if($searchArray['subnet']) {
			$searchString .= "AND address << {$this->db->escape($searchArray['subnet'])} ";
		}
		if($searchArray['range']) {
			if($searchArray['range'] == 'null') {
				$searchString .= "AND range IS NULL ";
			} else {
				$searchString .= "AND range ~* {$this->db->escape($searchArray['range'])} ";
			}
		}
		if($searchArray['hostname']) {
			if($searchArray['hostname'] == 'null') {
				$searchString .= "AND hostname IS NULL ";
			} else {
				$searchString .= "AND (hostname ~* {$this->db->escape($searchArray['hostname'])} OR cname_alias ~* {$this->db->escape($searchArray['hostname'])} OR srv_alias ~* {$this->db->escape($searchArray['hostname'])}) ";
			}
		}
		if($searchArray['zone']) {
			if($searchArray['zone'] == 'null') {
				$searchString .= "AND zone IS NULL ";
			} else {
				$searchString .= "AND zone ~* {$this->db->escape($searchArray['zone'])} ";
			}
		}
		if($searchArray['owner']) {
			if($searchArray['owner'] == 'null') {
				$searchString .= "AND system_owner IS NULL ";
			} else {
				$searchString .= "AND system_owner ~* {$this->db->escape($searchArray['owner'])} AND dns_owner = {$this->db->escape($searchArray['owner'])} ";
			}
		}
		if($searchArray['lastmodifier']) {
			if($searchArray['lastmodifier'] == 'null') {
				$searchString .= "AND system_last_modifier IS NULL OR dns_last_modifier IS NULL ";
			} else {
				$searchString .= "AND system_last_modifier ~* {$this->db->escape($searchArray['lastmodifier'])} AND dns_last_modifier = {$this->db->escape($searchArray['lastmodifier'])} ";
			}
		}

		$searchString .= " ORDER BY system_owner ASC";
		
		// SQL Query
		$sql = "SELECT * FROM api.get_search_data() {$searchString}";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		return $query;
	}

	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS

	/**
	 * Load all of the sub models that contain the actual API functions
	 * @return void
	 */
	private function _load() {
		$this->load->model('API/api_dhcp');
		$this->load->model('API/api_dns');
		$this->load->model('API/api_ip');
		$this->load->model('API/api_management');
		$this->load->model('API/api_network');
		$this->load->model('API/api_systems');
		$this->load->model('API/api_libvirt');
	}
}
/* End of file api.php */
/* Location: ./application/models/api.php */
