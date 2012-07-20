<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class Vlan extends ImpulseObject{

	private $datacenter;

	private $vlan;

	private $name;

	private $comment;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	/**
	 */
	public function __construct($datacenter, $vlan, $name, $comment, $dateCreated, $dateModified, $lastModifier) {
		parent::__construct($dateCreated, $dateModified, $lastModifier);

		$this->datacenter = $datacenter;
		$this->vlan = $vlan;
		$this->comment = $comment;
		$this->name = $name;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_datacenter()	     { return $this->datacenter; }
	public function get_vlan()	{ return $this->vlan; }
	public function get_comment()      { return $this->comment; }
	public function get_name()      { return $this->name; }

	////////////////////////////////////////////////////////////////////////
	// GETTERS

	public function set_datacenter($new) {
		$this->CI->api->network->modify->vlan($this->datacenter, $this->vlan, 'datacenter', $new);
		$this->datacenter = $new;
	}

	public function set_vlan($new) {
		$this->CI->api->network->modify->vlan($this->datacenter, $this->vlan, 'vlan', $new);
		$this->vlan = $new;
	}

	public function set_comment($new) {
		$this->CI->api->network->modify->vlan($this->datacenter, $this->vlan, 'comment', $new);
		$this->comment= $new;
	}

	public function set_name($new) {
		$this->CI->api->network->modify->vlan($this->datacenter, $this->vlan, 'name', $new);
		$this->name= $new;
	}
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC FUNCTIONS

}
/* End of file Vlan.php */
/* Location: ./application/libraries/objects/Vlan.php */
