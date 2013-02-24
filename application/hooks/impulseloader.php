<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImpulseLoader {
	public function initialize() {

		# Core
		require_once(APPPATH . "libraries/core/ImpulseObject.php");

		# Objects
		require_once(APPPATH . "libraries/objects/DnsRecord.php");
		require_once(APPPATH . "libraries/objects/AddressRecord.php");
		require_once(APPPATH . "libraries/objects/InterfaceAddress.php");
		require_once(APPPATH . "libraries/objects/MxRecord.php");
		require_once(APPPATH . "libraries/objects/NetworkInterface.php");
		require_once(APPPATH . "libraries/objects/NsRecord.php");
		require_once(APPPATH . "libraries/objects/CnameRecord.php");
		require_once(APPPATH . "libraries/objects/SrvRecord.php");
		require_once(APPPATH . "libraries/objects/System.php");
		require_once(APPPATH . "libraries/objects/TextRecord.php");
		require_once(APPPATH . "libraries/objects/ZoneAddressRecord.php");
		require_once(APPPATH . "libraries/objects/ZoneTextRecord.php");
		require_once(APPPATH . "libraries/objects/SystemType.php");

		require_once(APPPATH . "libraries/objects/ConfigType.php");
		require_once(APPPATH . "libraries/objects/ConfigClass.php");
		require_once(APPPATH . "libraries/objects/IpRange.php");
		require_once(APPPATH . "libraries/objects/Subnet.php");
		require_once(APPPATH . "libraries/objects/DnsZone.php");
		require_once(APPPATH . "libraries/objects/DnsKey.php");
		require_once(APPPATH . "libraries/objects/SoaRecord.php");
		require_once(APPPATH . "libraries/objects/Platform.php");
		require_once(APPPATH . "libraries/objects/Datacenter.php");
		require_once(APPPATH . "libraries/objects/AvailabilityZone.php");
		#require_once(APPPATH . "libraries/objects/IpAddress.php");
		require_once(APPPATH . "libraries/objects/DhcpOption.php");
		require_once(APPPATH . "libraries/objects/GlobalOption.php");
		require_once(APPPATH . "libraries/objects/ClassOption.php");
		require_once(APPPATH . "libraries/objects/RangeOption.php");
		require_once(APPPATH . "libraries/objects/SubnetOption.php");
		require_once(APPPATH . "libraries/objects/ConfigItem.php");
		require_once(APPPATH . "libraries/objects/Group.php");
		require_once(APPPATH . "libraries/objects/GroupSettings.php");
		require_once(APPPATH . "libraries/objects/GroupMember.php");
		require_once(APPPATH . "libraries/objects/SnmpCred.php");
		require_once(APPPATH . "libraries/objects/Switchport.php");
		require_once(APPPATH . "libraries/objects/Vlan.php");
		require_once(APPPATH . "libraries/objects/CamEntry.php");
		require_once(APPPATH . "libraries/objects/Blade.php");
		require_once(APPPATH . "libraries/objects/LibvirtHost.php");
		require_once(APPPATH . "libraries/objects/LibvirtDomain.php");

		#require_once(APPPATH . "libraries/objects/NetworkSwitchport.php");
		#require_once(APPPATH . "libraries/objects/NetworkSystem.php");

		require_once(APPPATH . "libraries/objects/User.php");
		
		# Exceptions
		#require_once(APPPATH . "libraries/exceptions/ControllerException.php");
		#require_once(APPPATH . "libraries/exceptions/ObjectException.php");
		#require_once(APPPATH . "libraries/exceptions/AmbiguousTargetException.php");
		#require_once(APPPATH . "libraries/exceptions/DBException.php");
		require_once(APPPATH . "libraries/exceptions/ObjectNotFoundException.php");
		require_once(APPPATH . "libraries/exceptions/APIException.php");
	}

	public function hookExceptions() {
		require_once(APPPATH . "libraries/exceptions/ObjectNotFoundException.php");
		require_once(APPPATH . "libraries/exceptions/APIException.php");
	}
}
