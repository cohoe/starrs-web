<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class for zone-based TXT records
 */
class ZoneTextRecord extends DnsRecord {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES
	
	// string		The text to describe an existing A or AAAA record
	private $text;

	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR
	
	/**
	 * @param	string	$hostname		The hostname of the record
	 * @param	string	$zone			The zone of the record
	 * @param	string	$address		The resolving address of the record
	 * @param	string	$type			The type of the record
	 * @param	int		$ttl			The time-to-live of the record
	 * @param	string	$owner			The owner of the record
	 * @param	string	$text			The text to place in the record
	 * @param	long	$dateCreated	Unix timestamp when the record was created
	 * @param	long	$dateModified	Unix timestamp when the record was modified
	 * @param	string	$lastModifier	The last user to modify the record
	 */
	public function __construct($hostname, $zone, $address, $type, $ttl, $text, $dateCreated, $dateModified, $lastModifier) {
		// @todo: Fixthis
		$owner = null;
		// Chain into the parent
		parent::__construct($hostname, $zone, $address, $type, $ttl, $owner, $dateCreated, $dateModified, $lastModifier);
		
		// TxtRecord-specific stuff
		$this->text = $text;
	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_text() { return $this->text; }

    ////////////////////////////////////////////////////////////////////////
	// SETTERS

    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS

	public function set_hostname($new) {
		$this->CI->api->dns->modify->zone_text($this->hostname, $this->zone, $this->text, 'hostname', $new);
		$this->hostname = $new;
	}

	public function set_zone($new) {
		$this->CI->api->dns->modify->zone_text($this->hostname, $this->zone, $this->text, 'zone', $new);
		$this->zone = $new;
	}

	public function set_ttl($new) {
		$this->CI->api->dns->modify->zone_text($this->hostname, $this->zone, $this->text, 'ttl', $new);
		$this->ttl = $new;
	}

	public function set_owner($new) {
		$this->CI->api->dns->modify->zone_text($this->hostname, $this->zone, $this->text, 'owner', $new);
		$this->owner = $new;
	}

	public function set_text($new) {
		$this->CI->api->dns->modify->zone_text($this->hostname, $this->zone, $this->text, 'text', $new);
		$this->owner = $new;
	}
    
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file ZoneTextRecord.php */
/* Location: ./application/libraries/objects/ZoneTextRecord.php */
