<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class for all Nameserver (NS) records
 */
class NsRecord extends DnsRecord {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	private $nameserver;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	/**
	 * @param	string	$hostname		The hostname of the record
	 * @param	string	$zone			The zone of the record
	 * @param	string	$address		The resolving address of the record
	 * @param	string	$type			The type of the record
	 * @param	int		$ttl			The time-to-live of the record
	 * @param	string	$owner			The owner of the record
	 * @param	bool	$isPrimary		Is this nameserver the primary for the zone?
	 * @param	long	$dateCreated	Unix timestamp when the record was created
	 * @param	long	$dateModified	Unix timestamp when the record was modifed
	 * @param	string	$lastModifier	The last user to modify the record
	 */
	public function __construct($nameserver, $zone, $address, $type, $ttl, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($nameserver, $zone, $address, $type, $ttl, null, $dateCreated, $dateModified, $lastModifier);
		
		// NsRecord-specific stuff
		$this->nameserver = $nameserver;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	//
	public function get_nameserver() { return $this->nameserver; }
	
	////////////////////////////////////////////////////////////////////////
    // SETTERS
	public function set_zone($new) {
		$this->CI->api->dns->modify->ns($this->zone, $this->nameserver, 'zone', $new);
		$this->zone = $new;
	}

	public function set_ttl($new) {
		$this->CI->api->dns->modify->ns($this->zone, $this->nameserver, 'ttl', $new);
		$this->ttl = $new;
	}

	public function set_nameserver($new) {
		$this->CI->api->dns->modify->ns($this->zone, $this->nameserver, 'nameserver', $new);
		$this->nameserver = $new;
	}

	public function set_address($new) {
		$this->CI->api->dns->modify->ns($this->zone, $this->nameserver, 'address', $new);
		$this->address = $new;
	}


    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS

	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file NsRecord.php */
/* Location: ./application/libraries/objects/NsRecord.php */
