<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class Platform extends ImpulseObject {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	private $platformName;

	private $architecture;

	private $disk;

	private $cpu;

	private $memory;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	public function __construct($platformName, $architecture, $disk, $cpu, $memory, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Store the rest of the data
		$this->platformName = $platformName;
		$this->architecture = $architecture;
		$this->disk = $disk;
		$this->cpu = $cpu;
		$this->memory = $memory;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_platform_name() { return $this->platformName; }
	public function get_architecture() { return $this->architecture; }
	public function get_disk() { return $this->disk; }
	public function get_cpu() { return $this->cpu; }
	public function get_memory() { return $this->memory; }

	////////////////////////////////////////////////////////////////////////
	// SETTERS

	public function set_platform_name($new) {
		$this->CI->api->systems->modify->platform($this->platformName, 'platform_name', $new);
		$this->platformName = $new;
	}
	public function set_architecture($new) {
		$this->CI->api->systems->modify->platform($this->platformName, 'architecture', $new);
		$this->architecture = $new;
	}
	public function set_disk($new) {
		$this->CI->api->systems->modify->platform($this->platformName, 'disk', $new);
		$this->disk = $new;
	}
	public function set_cpu($new) {
		$this->CI->api->systems->modify->platform($this->platformName, 'cpu', $new);
		$this->cpu = $new;
	}
	public function set_memory($new) {
		$this->CI->api->systems->modify->platform($this->platformName, 'memory', $new);
		$this->memory = $new;
	}
    
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file Platform.php */
/* Location: ./application/libraries/objects/Platform.php */
