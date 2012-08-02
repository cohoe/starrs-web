<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseModel.php");

/**
 *	DNS
 */
class Api_dns_create extends ImpulseModel {
	
	public function key($keyname, $key, $enctype, $owner, $comment) {
		// SQL Query
		$sql = "SELECT * FROM api.create_dns_key(
			{$this->db->escape($keyname)},
			{$this->db->escape($key)},
			{$this->db->escape($enctype)},
			{$this->db->escape($owner)},
			{$this->db->escape($comment)}
		)";
		$query = $this->db->query($sql);
		
		// Check error
		$this->_check_error($query);
		
		if($query->num_rows() > 1) {
			throw new APIException("The database returned more than one new key. Contact your system administrator");
		}
		
		// Return object
		return new DnsKey(
			$query->row()->keyname,
			$query->row()->key,
			$query->row()->enctype,
			$query->row()->owner,
			$query->row()->comment,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
	
	public function zone($zone, $keyname, $forward, $shared, $owner, $comment, $ddns) {
		// SQL Query
		$zonesql = "SELECT * FROM api.create_dns_zone(
			{$this->db->escape($zone)},
			{$this->db->escape($keyname)},
			{$this->db->escape($forward)},
			{$this->db->escape($shared)},
			{$this->db->escape($owner)},
			{$this->db->escape($comment)},
			{$this->db->escape($ddns)}
		)";
		$zonequery = $this->db->query($zonesql);

		// Check error
		$this->_check_error($zonequery);
		
		// Return object
		return new DnsZone(
			$zonequery->row()->zone,
			$zonequery->row()->keyname,
			$zonequery->row()->forward,
			$zonequery->row()->shared,
			$zonequery->row()->owner,
			$zonequery->row()->comment,
			$zonequery->row()->ddns,
			$zonequery->row()->date_created,
			$zonequery->row()->date_modified,
			$zonequery->row()->last_modifier
		);

		return $objects;
	}

	public function soa($zone) {
		$sql = "SELECT * FROM api.create_dns_soa({$this->db->escape($zone)})";
		$query = $this->db->query($sql);

		$this->_check_error($query);

		return new SoaRecord(
			$query->row()->zone,
			$query->row()->nameserver,
			$query->row()->ttl,
			$query->row()->contact,
			$query->row()->serial,
			$query->row()->refresh,
			$query->row()->retry,
			$query->row()->expire,
			$query->row()->minimum,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

     public function address($address, $hostname, $zone, $ttl, $type, $reverse, $owner) {
		// SQL Query
		$sql = "SELECT * FROM api.create_dns_address(
			{$this->db->escape($address)},
			{$this->db->escape($hostname)},
			{$this->db->escape($zone)},
			{$this->db->escape($ttl)},
			{$this->db->escape($type)},
			{$this->db->escape($reverse)},
			{$this->db->escape($owner)}
		)";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
		
		// Return object
		return new AddressRecord(
			$query->row()->hostname,
			$query->row()->zone,
			$query->row()->address,
			$query->row()->type,
			$query->row()->ttl,
			$query->row()->owner,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
	
	public function mx($hostname, $zone, $preference, $ttl, $owner) {
		// SQL Query
		$sql = "SELECT * FROM api.create_dns_mailserver(
			{$this->db->escape($hostname)},
			{$this->db->escape($zone)},
			{$this->db->escape($preference)},
			{$this->db->escape($ttl)},
			{$this->db->escape($owner)}
		)";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

        if($query->num_rows() > 1) {
			throw new APIException("The database returned more than one new record. Contact your system administrator");
		}

		// Return object
		return new MxRecord(
            $query->row()->hostname,
            $query->row()->zone,
            $query->row()->address,
            $query->row()->type,
            $query->row()->ttl,
            $query->row()->owner,
            $query->row()->preference,
            $query->row()->date_created,
            $query->row()->date_modified,
            $query->row()->last_modifier
        );
	}

    public function ns($zone, $nameserver, $address, $ttl) {
		// SQL Query
		$sql = "SELECT * FROM api.create_dns_ns(
			{$this->db->escape($zone)},
			{$this->db->escape($nameserver)},
			{$this->db->escape($address)},
			{$this->db->escape($ttl)}
		)";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);
        
        if($query->num_rows() > 1) {
			throw new APIException("The database returned more than one new record. Contact your system administrator");
		}

		// Return object
		return new NsRecord(
            $query->row()->nameserver,
            $query->row()->zone,
            $query->row()->address,
            $query->row()->type,
            $query->row()->ttl,
            $query->row()->date_created,
            $query->row()->date_modified,
            $query->row()->last_modifier
        );
	}
	
	public function srv($alias, $hostname, $zone, $priority, $weight, $port, $ttl, $owner) {
		// SQL Query
		$sql = "SELECT * FROM api.create_dns_srv(
			{$this->db->escape($alias)},
			{$this->db->escape($hostname)},
			{$this->db->escape($zone)},
			{$this->db->escape($priority)},
			{$this->db->escape($weight)},
			{$this->db->escape($port)},
			{$this->db->escape($ttl)},
			{$this->db->escape($owner)}
		)";

		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

        if($query->num_rows() > 1) {
			throw new APIException("The database returned more than one new record. Contact your system administrator");
		}

		// Return object
		return new SrvRecord(
            $query->row()->alias,
            $query->row()->hostname,
            $query->row()->zone,
            $query->row()->address,
            $query->row()->type,
            $query->row()->ttl,
            $query->row()->owner,
            $query->row()->priority,
            $query->row()->weight,
            $query->row()->port,
            $query->row()->date_created,
            $query->row()->date_modified,
            $query->row()->last_modifier
        );
	}

	public function cname($alias, $hostname, $zone, $ttl, $owner) {
		// SQL Query
		$sql = "SELECT * FROM api.create_dns_cname(
			{$this->db->escape($alias)},
			{$this->db->escape($hostname)},
			{$this->db->escape($zone)},
			{$this->db->escape($ttl)},
			{$this->db->escape($owner)}
		)";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		if($query->num_rows() > 1) {
			throw new APIException("The database returned more than one new record. Contact your system administrator");
		}

		// Return object
		return new CnameRecord(
            $query->row()->alias,
            $query->row()->hostname,
            $query->row()->zone,
            $query->row()->address,
            $query->row()->type,
            $query->row()->ttl,
            $query->row()->owner,
            $query->row()->date_created,
            $query->row()->date_modified,
            $query->row()->last_modifier
        );
	}

	public function txt($hostname, $zone, $text, $ttl, $owner) {
		// SQL Query
		$sql = "SELECT * FROM api.create_dns_txt(
			{$this->db->escape($hostname)},
			{$this->db->escape($zone)},
			{$this->db->escape($text)},
			{$this->db->escape($ttl)},
			{$this->db->escape($owner)}
		)";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		if($query->num_rows() > 1) {
			throw new APIException("The database returned more than one new record. Contact your system administrator");
		}

		// Return object
		return new TextRecord(
            $query->row()->hostname,
            $query->row()->zone,
            $query->row()->address,
            $query->row()->type,
            $query->row()->ttl,
            $query->row()->owner,
            $query->row()->text,
            $query->row()->date_created,
            $query->row()->date_modified,
            $query->row()->last_modifier
        );
	}

	public function zonea($zone=null,$address=null,$ttl=null) {
		// SQL
		$sql = "SELECT * FROM api.create_dns_zone_a({$this->db->escape($zone)},{$this->db->escape($address)},{$this->db->escape($ttl)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
		return new ZoneAddressRecord(
			$query->row()->hostname,
			$query->row()->zone,
			$query->row()->address,
			$query->row()->type,
			$query->row()->ttl,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}

	public function zonetxt($hostname=null,$zone=null,$text=null,$ttl=null) {
		// SQL
		$sql = "SELECT * FROM api.create_dns_zone_txt({$this->db->escape($hostname)},{$this->db->escape($zone)},{$this->db->escape($text)},{$this->db->escape($ttl)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
		return new ZoneTextRecord(
			$query->row()->hostname,
			$query->row()->zone,
			$query->row()->address,
			$query->row()->type,
			$query->row()->ttl,
			$query->row()->text,
			$query->row()->date_created,
			$query->row()->date_modified,
			$query->row()->last_modifier
		);
	}
}
/* End of file api_dns_create.php */
/* Location: ./application/models/API/DNS/api_dns_create.php */
