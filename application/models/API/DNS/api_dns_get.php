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

	public function recordsBySystem($systemName=null) {
		//SQL Queries
		$aSQL = "SELECT * FROM api.get_dns_a(null,null) WHERE api.get_interface_address_system(address) = {$this->db->escape($systemName)} ORDER BY address";
		$cnameSQL = "SELECT * FROM api.get_dns_cname(null) WHERE api.get_interface_address_system(address) = {$this->db->escape($systemName)} ORDER BY address";
		$mxSQL = "SELECT * FROM api.get_dns_mx(null) WHERE api.get_interface_address_system(address) = {$this->db->escape($systemName)} ORDER BY address";
		$srvSQL = "SELECT * FROM api.get_dns_srv(null) WHERE api.get_interface_address_system(address) = {$this->db->escape($systemName)} ORDER BY address";
		$txtSQL = "SELECT * FROM api.get_dns_txt(null) WHERE api.get_interface_address_system(address) = {$this->db->escape($systemName)} ORDER BY address";

		$aQuery = $this->db->query($aSQL);
		try { $this->_check_error($aQuery); }
		catch (ObjectNotFoundException $e) {}
		
		$cnameQuery = $this->db->query($cnameSQL);
		try { $this->_check_error($cnameQuery); }
		catch (ObjectNotFoundException $e) {}

		$mxQuery = $this->db->query($mxSQL);
		try { $this->_check_error($mxQuery); }
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


	public function recordsByAddress($address=null) {
		//SQL Queries
		$aSQL = "SELECT * FROM api.get_dns_a({$this->db->escape($address)},null)";
		$cnameSQL = "SELECT * FROM api.get_dns_cname({$this->db->escape($address)})";
		$mxSQL = "SELECT * FROM api.get_dns_mx({$this->db->escape($address)})";
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
}
/* End of file api_dns_get.php */
/* Location: ./application/models/API/DNS/api_dns_get.php */
