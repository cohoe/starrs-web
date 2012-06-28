<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class for all SRV records
 */
class SrvRecord extends DnsRecord {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	// string	The pointer name
	private $alias;
	
    // int      The priority field of a SRV record
	private $priority;

    // int      The weight field of a SRV record
	private $weight;

    // int      The port of the SRV field
	private $port;
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	/**
	 * @param	string	$alias			The alias hostname of the record
	 * @param	string	$hostname		The hostname of the record
	 * @param	string	$zone			The zone of the record
	 * @param	string	$address		The resolving address of the record
	 * @param	string	$type			The type of the record
	 * @param	int		$ttl			The time-to-live of the record
	 * @param	string	$owner			The owner of the record
	 * @param int       $priority      Priority of the record
	 * @param int       $weight        Weight of the record if equal priority
	 * @param int       $port      Port of the service
	 * @param	long	$dateCreated	Unix timestamp when the record was created
	 * @param	long	$dateModified	Unix timestamp when the record was modifed
	 * @param	string	$lastModifier	The last user to modify the record
	 */
	public function __construct($alias, $hostname, $zone, $address, $type, $ttl, $owner, $priority, $weight, $port, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($hostname, $zone, $address, $type, $ttl, $owner, $dateCreated, $dateModified, $lastModifier);
		
		// PointerRecord-specific stuff
		$this->alias = $alias;
		$this->priority = $priority;
		$this->weight = $weight;
		$this->port = $port;
	}
	
	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_alias() { return $this->alias; }
	public function get_priority() { return $this->priority; }
	public function get_weight()   { return $this->weight; }
	public function get_port()     { return $this->port; }

    ////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_hostname($new) {
		$this->CI->api->dns->modify->srv($this->alias, $this->zone, 'hostname', $new);	
		$this->hostname = $new; 
	}
	
	public function set_zone($new) {
		$this->CI->api->dns->modify->srv($this->alias, $this->zone, 'zone', $new);	
		$this->zone = $new; 
	}
	
	public function set_ttl($new) {
		$this->CI->api->dns->modify->srv($this->alias, $this->zone, $this->priority, $this->weight, $this->port, 'ttl', $new);	
		$this->ttl = $new; 
	}
	
	public function set_owner($new) {
		$this->CI->api->dns->modify->srv($this->alias, $this->zone, $this->priority, $this->weight, $this->port, 'owner', $new);	
		$this->owner = $new; 
	}
	
	public function set_alias($new) {
		$this->CI->api->dns->modify->srv($this->alias, $this->zone, $this->priority, $this->weight, $this->port, 'alias', $new);	
		$this->alias = $new; 
	}
	
	public function set_priority($new) {
		$this->CI->api->dns->modify->srv($this->alias, $this->zone, $this->priority, $this->weight, $this->port, 'priority', $new);	
		$this->priority = $new; 
	}
	
	public function set_weight($new) {
		$this->CI->api->dns->modify->srv($this->alias, $this->zone, $this->priority, $this->weight, $this->port, 'weight', $new);	
		$this->priority = $new; 
	}
	
	public function set_port($new) {
		$this->CI->api->dns->modify->srv($this->alias, $this->zone, $this->priority, $this->weight, $this->port, 'port', $new);	
		$this->priority = $new; 
	}

    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS

    ////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file SrvRecord.php */
/* Location: ./application/libraries/objects/SrvRecord.php */
