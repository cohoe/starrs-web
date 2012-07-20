<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Switchport {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	private $systemName;
	
	private $adminState;
	
	private $operState;
	
	private $name;
	
	private $description;
	
	private $alias;
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	public function __construct($systemName, $adminState, $operState, $name, $description, $alias, $date) {
		$this->systemName = $systemName;
		$this->adminState = $adminState;
		$this->operState = $operState;
		$this->name = $name;
		$this->description = $description;
		$this->alias = $alias;
		$this->date = $date;
	}
	
	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_system_name() { return $this->systemName; }
	public function get_admin_state() { return $this->adminState; }
	public function get_oper_state()  { return $this->operState; }
	public function get_name()        { return $this->name; }
	public function get_description() { return $this->description; }
	public function get_alias()       { return $this->alias; }
	public function get_date()       { return $this->date; }
	
	////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
}
/* End of file Switchport.php */
/* Location: ./application/libraries/objects/Switchport.php */
