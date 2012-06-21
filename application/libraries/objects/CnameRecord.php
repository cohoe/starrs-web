<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class for CNAME records
 */
class CnameRecord extends DnsRecord {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	// string	The pointer name
	private $alias;
	
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
	 * @param	long	$dateCreated	Unix timestamp when the record was created
	 * @param	long	$dateModified	Unix timestamp when the record was modifed
	 * @param	string	$lastModifier	The last user to modify the record
	 */
	public function __construct($alias, $hostname, $zone, $address, $type, $ttl, $owner, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($hostname, $zone, $address, $type, $ttl, $owner, $dateCreated, $dateModified, $lastModifier);
		
		// PointerRecord-specific stuff
		$this->alias = $alias;
	}
	
	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_alias() { return $this->alias; }

    ////////////////////////////////////////////////////////////////////////
	// SETTERS
	
	public function set_hostname($new) {
		$this->CI->api->dns->modify->cname($this->alias, $this->zone, 'hostname', $new);	
		$this->hostname = $new; 
	}
	
	public function set_zone($new) {
		$this->CI->api->dns->modify->cname($this->alias, $this->zone, 'zone', $new);	
		$this->zone = $new; 
	}
	
	public function set_ttl($new) {
		$this->CI->api->dns->modify->cname($this->alias, $this->zone, 'ttl', $new);	
		$this->ttl = $new; 
	}
	
	public function set_owner($new) {
		$this->CI->api->dns->modify->cname($this->alias, $this->zone, 'owner', $new);	
		$this->owner = $new; 
	}
	
	public function set_alias($new) {
		$this->CI->api->dns->modify->cname($this->alias, $this->zone, 'alias', $new);	
		$this->alias = $new; 
	}
	
    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS

    ////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file CnameRecord.php */
/* Location: ./application/libraries/objects/CnameRecord.php */
