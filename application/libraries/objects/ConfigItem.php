<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ConfigItem extends ImpulseObject {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	protected $option;
	protected $value;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR

    public function __construct($option, $value, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// Object specific data
		$this->option = $option;
		$this->value  = $value;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_option() { return $this->option; }
	public function get_value()  { return $this->value; }

    ////////////////////////////////////////////////////////////////////////
	// SETTERS

	public function set_value($new) {
		$this->CI->api->modify->site_configuration($this->option, $new);
		$this->value = $new;
	}

    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
    
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file ConfigItem.php */
/* Location: ./application/libraries/objects/ConfigItem.php */
