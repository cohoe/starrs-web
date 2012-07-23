<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CamEntry extends ImpulseObject {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	private $systemName;

	private $switchPort;

	private $mac;
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	public function __construct($systemName, $switchPort, $mac, $dateCreated, $dateModified, $lastModifier) {
		parent::__construct($dateCreated, $dateModified, $lastModifier);

		$this->systemName = $systemName;
		$this->switchPort = $switchPort;
		$this->mac = $mac;
	}
	
	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_system_name() { return $this->systemName; }
	public function get_switchport()       { return $this->switchPort; }
	public function get_mac()       { return $this->mac; }
	
	////////////////////////////////////////////////////////////////////////
	// SETTERS

	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
}
/* End of file CamEntry.php */
/* Location: ./application/libraries/objects/CamEntry.php */
