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
}
/* End of file api_dns_get.php */
/* Location: ./application/models/API/DNS/api_dns_get.php */
