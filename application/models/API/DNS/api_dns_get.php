<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	DNS
 */
class Api_dns_get extends ImpulseModel {

    public function addressesBySystem($systemName=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_dns_a(null,null) WHERE api.get_interface_address_system(address) = {$this->db->escape($systemName)} ORDER BY address";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Generate & return result
        $resultSet = array();
        foreach ($query->result_array() as $aRecord) {
            $resultSet[] = new AddressRecord(
                $aRecord['hostname'],
                $aRecord['zone'],
                $aRecord['address'],
                $aRecord['type'],
                $aRecord['ttl'],
                $aRecord['owner'],
                $aRecord['date_created'],
                $aRecord['date_modified'],
                $aRecord['last_modifier']
            );
        }

		return $resultSet;
	}

	public function recordsByAddress($address=null) {
		//SQL Queries
		$aSQL = "SELECT * FROM api.get_dns_a({$this->db->escape($address)},null)";
		$cnameSQL = "SELECT * FROM api.get_dns_cname({$this->db->escape($address)})";
		$mxSQL = "SELECT * FROM api.get_dns_mx({$this->db->escape($address)})";
		$nsSQL = "SELECT * FROM api.get_dns_ns(null) WHERE address = {$this->db->escape($address)}";
		$srvSQL = "SELECT * FROM api.get_dns_srv({$this->db->escape($address)})";
		$txtSQL = "SELECT * FROM api.get_dns_txt({$this->db->escape($address)})";

		$aQuery = $this->db->query($aSQL);
		try { $this->_check_error($aQuery); }
		catch (ObjectNotFoundException $e) {}
		
		$cnameQuery = $this->db->query($cnameSQL);
		try { $this->_check_error($cnameQuery); }
		catch (ObjectNotFoundException $e) {}

		$mxQuery = $this->db->query($mxSQL);
		try { $this->_check_error($mxQuery); }
		catch (ObjectNotFoundException $e) {}

		$nsQuery = $this->db->query($nsSQL);
		try { $this->_check_error($nsQuery); }
		catch (ObjectNotFoundException $e) {}

		$srvQuery = $this->db->query($srvSQL);
		try { $this->_check_error($srvQuery); }
		catch (ObjectNotFoundException $e) {}

		$txtQuery = $this->db->query($txtSQL);
		try { $this->_check_error($txtQuery); }
		catch (ObjectNotFoundException $e) {}

		// Generate Results
		$resultSet = array();

		foreach($aQuery->result_array() as $aRecord) {
			$resultSet[] = new AddressRecord(
				$aRecord['hostname'],
				$aRecord['zone'],
				$aRecord['address'],
				$aRecord['type'],
				$aRecord['ttl'],
				$aRecord['owner'],
				$aRecord['date_created'],
				$aRecord['date_modified'],
				$aRecord['last_modifier']
			);
		}

		foreach($cnameQuery->result_array() as $cnameRecord) {
			$resultSet[] = new CnameRecord(
				$cnameRecord['alias'],
				$cnameRecord['hostname'],
				$cnameRecord['zone'],
				$cnameRecord['address'],
				$cnameRecord['type'],
				$cnameRecord['ttl'],
				$cnameRecord['owner'],
				$cnameRecord['date_created'],
				$cnameRecord['date_modified'],
				$cnameRecord['last_modifier']
			);
		}

		foreach($mxQuery->result_array() as $mxRecord) {
			$resultSet[] = new MxRecord(
				$mxRecord['hostname'],
				$mxRecord['zone'],
				$mxRecord['address'],
				$mxRecord['type'],
				$mxRecord['ttl'],
				$mxRecord['owner'],
				$mxRecord['preference'],
				$mxRecord['date_created'],
				$mxRecord['date_modified'],
				$mxRecord['last_modifier']
			);
		}

		foreach($nsQuery->result_array() as $nsRecord) {
			$resultSet[] = new NsRecord(
				$nsRecord['nameserver'],
				$nsRecord['zone'],
				$nsRecord['address'],
				$nsRecord['type'],
				$nsRecord['ttl'],
				$nsRecord['date_created'],
				$nsRecord['date_modified'],
				$nsRecord['last_modifier']
			);
		}
		  

		foreach($srvQuery->result_array() as $srvRecord) {
			$resultSet[] = new SrvRecord(
				$srvRecord['alias'],
				$srvRecord['hostname'],
				$srvRecord['zone'],
				$srvRecord['address'],
				$srvRecord['type'],
				$srvRecord['ttl'],
				$srvRecord['owner'],
				$srvRecord['priority'],
				$srvRecord['weight'],
				$srvRecord['port'],
				$srvRecord['date_created'],
				$srvRecord['date_modified'],
				$srvRecord['last_modifier']
			);
		}

		foreach($txtQuery->result_array() as $txtRecord) {
			$resultSet[] = new TextRecord(
				$txtRecord['hostname'],
				$txtRecord['zone'],
				$txtRecord['address'],
				$txtRecord['type'],
				$txtRecord['ttl'],
				$txtRecord['owner'],
				$txtRecord['text'],
				$txtRecord['date_created'],
				$txtRecord['date_modified'],
				$txtRecord['last_modifier']
			);
		}

		// Return Results
		return $resultSet;
	}

	public function zonesByUser($username) {
		// SQL Query
		$sql = "SELECT * FROM api.get_dns_zones({$this->db->escape($username)})";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Results
		$resultSet = array();
		foreach($query->result_array() as $zone) {
			$resultSet[] = new DnsZone(
				$zone['zone'],
				$zone['keyname'],
				$zone['forward'],
				$zone['shared'],
				$zone['owner'],
				$zone['comment'],
				$zone['date_created'],
				$zone['date_modified'],
				$zone['last_modifier']
			);
		}

		// Return
		return $resultSet;
	}

	public function keysByOwner($username) {
		// SQL Query
		$sql = "SELECT * FROM api.get_dns_keys({$this->db->escape($username)})";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Results
		$resultSet = array();
		foreach($query->result_array() as $key) {
			$resultSet[] = new DnsKey(
				$key['keyname'],
				$key['key'],
				$key['owner'],
				$key['comment'],
				$key['date_created'],
				$key['date_modified'],
				$key['last_modifier']
			);
		}

		// Return
		return $resultSet;
	}

	public function recordtypes() {
		// SQL Query
		$sql = "SELECT * FROM api.get_record_types()";
		$query = $this->db->query($sql);

		// Check Error
		$this->_check_error($query);

		// Return
		$resultSet = array();
		foreach($query->result_array() as $type) {
			$resultSet[] = $type['get_record_types'];
		}

		return $resultSet;
	}

	public function address($zone=null, $address=null) {
		// SQL Query
		$sql = "SELECT * FROM api.get_dns_a({$this->db->escape($address)},{$this->db->escape($zone)})";
		$query = $this->db->query($sql);

		// Check error
		$this->_check_error($query);

		// Return
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
}
/* End of file api_dns_get.php */
/* Location: ./application/models/API/DNS/api_dns_get.php */
