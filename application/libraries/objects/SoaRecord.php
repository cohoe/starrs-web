<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 */
class SoaRecord extends ImpulseObject {

	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES

	protected $zone;

	protected $nameserver;

	protected $ttl;

	protected $contact;

	protected $serial;

	protected $refresh;

	protected $retry;

	protected $expire;

	protected $minimum;

	protected $date_created;

	protected $date_modified;

	protected $last_modifier;
	
	public function __construct($zone, $nameserver, $ttl, $contact, $serial, $refresh, $retry, $expire, $minimum, $dateCreated, $dateModified, $lastModifier) {
		// Chain into the parent
		parent::__construct($dateCreated, $dateModified, $lastModifier);
		
		// DnsRecord specific stuff
		$this->zone = $zone;
		$this->nameserver = $nameserver;
		$this->ttl = $ttl;
		$this->contact = $contact;
		$this->serial = $serial;
		$this->refresh = $refresh;
		$this->retry = $retry;
		$this->expire = $expire;
		$this->minimum = $minimum;
		$this->last_modifier = $lastModifier;
		$this->date_created = $dateCreated;
		$this->date_modified = $dateModified;
	}
	
	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_zone()     { return $this->zone; }
	public function get_nameserver() { return $this->nameserver; }
	public function get_contact() { return $this->contact; }
	public function get_serial() { return $this->serial; }
	public function get_refresh() { return $this->refresh; }
	public function get_retry() { return $this->retry; }
	public function get_expire() { return $this->expire; }
	public function get_minimum() { return $this->minimum; }
	public function get_ttl()      { return $this->ttl; }

	////////////////////////////////////////////////////////////////////////
	// GETTERS

	public function set_nameserver($new) {
		$this->CI->api->dns->modify->soa($this->zone, 'nameserver', $new);
		$this->nameserver = $new;
	}
	
	public function set_ttl($new) {
		$this->CI->api->dns->modify->soa($this->zone, 'ttl', $new);
		$this->ttl = $new;
	}

	public function set_contact($new) {
		$this->CI->api->dns->modify->soa($this->zone, 'contact', $new);
		$this->contact = $new;
	}

	public function set_serial($new) {
		$this->CI->api->dns->modify->soa($this->zone, 'serial', $new);
		$this->serial = $new;
	}

	public function set_refresh($new) {
		$this->CI->api->dns->modify->soa($this->zone, 'refresh', $new);
		$this->refresh = $new;
	}

	public function set_retry($new) {
		$this->CI->api->dns->modify->soa($this->zone, 'retry', $new);
		$this->retry = $new;
	}

	public function set_expire($new) {
		$this->CI->api->dns->modify->soa($this->zone, 'expire', $new);
		$this->expire = $new;
	}

	public function set_minimum($new) {
		$this->CI->api->dns->modify->soa($this->zone, 'minimum', $new);
		$this->minimum = $new;
	}
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
	
	////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS
}
/* End of file SoaRecord.php */
/* Location: ./application/libraries/objects/SoaRecord.php */
