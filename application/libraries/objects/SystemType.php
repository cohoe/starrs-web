<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class SystemType {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	// string   The name of the type
	private $type;

	// string   Family of the type
	private $family;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	/**
	 * @param	string	$type
	 * @param	string	$family
	 */
	public function __construct($type, $family) {
		// Store the rest of the data
		$this->type = $type;
		$this->family = $family;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_family()        { return $this->family; }
	public function get_type()          { return $this->type; }
    
	////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
	
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file SystemType.php */
/* Location: ./application/libraries/objects/SystemType.php */
