<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Library of general functions for the operation of STARRS
 */
class Impulselib {

	private $fullName;
	private $uname;
	private $CI;
	private $tooltips;

	const createbtnclass = "success";

    /**
     * Constructor. This will load in your identification information for use in privilege leveling
     */
	function __construct() {
		$this->CI =& get_instance();
		
       	$this->uname = $this->CI->input->server($this->CI->config->item('imp_username_env'));
		$this->fullName = $this->CI->input->server($this->CI->config->item('imp_displayname_env'));

		$this->populate_tooltips();
	}

	public function test() {
		echo "Hi";
	}

    /**
     * Get a standard IPv6 autoconf address from your MAC address
     * @param $mac  The MAC address of the interface
     * @return string
     */
	function get_eui64_address($mac) {
		return $mac;
	}

	function get_tooltips() { return $this->tooltips; }

	private function populate_tooltips() {
		# Datacenters
		$this->tooltips['datacenter']['Date Created'] = "The date on which the datacenter was created.";
		$this->tooltips['datacenter']['Date Modified'] = "The date on which the datacenter was last modified.";
		$this->tooltips['datacenter']['Last Modifier'] = "The last user to modify the datacenter.";
		$this->tooltips['datacenter']['Comment'] = "A note about the datacenter.";

		# Availability zone
		$this->tooltips['availabilityzone']['Datacenter'] = "The datacenter in which the availability zone lives.";
		$this->tooltips['availabilityzone']['Date Created'] = "The date on which the availability zone was created.";
		$this->tooltips['availabilityzone']['Date Modified'] = "The date on which the availability zone was last modified.";
		$this->tooltips['availabilityzone']['Last Modifier'] = "The last user to modify the availability zone.";
		$this->tooltips['availabilityzone']['Comment'] = "A note about a particular availablility zone.";

		# Platform
		$this->tooltips['platform']['Architecture'] = "The CPU architecture of a given hardware platform.";
		$this->tooltips['platform']['Disk'] = "The disk configuration of a hardware platform.";
		$this->tooltips['platform']['CPU'] = "The CPU configuration of a hardware platform.";
		$this->tooltips['platform']['Memory'] = "The memory configuration of a hardware platform.";
		$this->tooltips['platform']['Date Created'] = "The date on which the platform was created.";
		$this->tooltips['platform']['Date Modified'] = "The date on which the platform was last modified.";
		$this->tooltips['platform']['Last Modifier'] = "The last user to modify the platform.";

		# Systems
		$this->tooltips['system']['Datacenter'] = "The physical location in which resources or objects reside. Used for physical asset tracking.";
		$this->tooltips['system']['Type'] = "A generic classification of a system. Used for enabling special features such as SNMP and Libvirt.";
		$this->tooltips['system']['Operating System'] = "The operating system loaded on the system. Used for fun statistics about the site.";
		$this->tooltips['system']['Owner'] = "The user that ownes the particiular resource. Used to associate all resources to a specific person.";
		$this->tooltips['system']['Group'] = "An owning group associated with a resource or object. Used for privileging and access control.";
		$this->tooltips['system']['Asset'] = "An organization-specified inventory management identifier attached to an object. Used for inventory management.";
		$this->tooltips['system']['Date Created'] = "The date on which the resource or object was created.";
		$this->tooltips['system']['Date Modified'] = "The date on which the resource or object was last modified.";
		$this->tooltips['system']['Last Modifier'] = "The last user to modify the resource or object.";
		$this->tooltips['system']['Comment'] = "A note associated with the object or resource.";

		$this->tooltips['system']['Platform'] = "A generic hardware configuration applied to a system. Used to enable certain features or views.";
		$this->tooltips['system']['Architecture'] = "The CPU architecture of a given hardware platform.";
		$this->tooltips['system']['Disk'] = "The disk configuration of a hardware platform.";
		$this->tooltips['system']['CPU'] = "The CPU configuration of a hardware platform.";
		$this->tooltips['system']['Memory'] = "The memory configuration of a hardware platform.";

		$this->tooltips['system']['System Name'] = "A logical name given to a computer system.";
		$this->tooltips['system']['Mac Address'] = "The EUI48 address from your NIC. This can be entered in Windows/Linux/Cisco notation.";
		$this->tooltips['system']['Range'] = "The IP address range to pull from when provisioning an address.";
		$this->tooltips['system']['Address'] = "The IP address that has been provisioned to you. This can be either IPv4 or IPv6.";
		$this->tooltips['system']['Config'] = "The method that you receive your IP address. DHCP(v6) addresses will be handed out by the DHCP server. Static addresses must be configured by the user. Autoconf addresses are treated like static addresses in STARRS, but are not configured on the system by a user.";
		$this->tooltips['system']['Zone'] = "The DNS domain name.";

		$this->tooltips['ip']['Name'] = "A logical/human readable name assigned to an IP subnet";
		$this->tooltips['ip']['DNS Zone'] = "A DNS domain associated with the subnet.";
		$this->tooltips[''][''] = "";
		$this->tooltips[''][''] = "";
		$this->tooltips[''][''] = "";
		$this->tooltips[''][''] = "";
		$this->tooltips[''][''] = "";
		$this->tooltips[''][''] = "";

		# DNS
		
		# IP

		# DHCP
		
		# Management

		# Network

		# Other
	}


    /**
     * Get the path of the OS image based on the OS name
     * @param $osname   The name of the OS to get
     * @return
     */
	function get_os_img_path($osname) {
		$paths['Cisco IOS'] = "/media/images/os/CiscoIOS.png";
		$paths['Windows XP'] = "/media/images/os/WindowsXP.png";
		$paths['Windows Vista'] = "/media/images/os/WindowsVista.png";
		$paths['Windows 7'] = "/media/images/os/Windows7.png";
		$paths['Windows Server 2003'] = "/media/images/os/WindowsServer2003.png";
		$paths['Windows Server 2008'] = "/media/images/os/WindowsServer2008.png";
		$paths['Windows Server 2008 R2'] = "/media/images/os/WindowsServer2008R2.png";
		$paths['Gentoo'] = "/media/images/os/Gentoo.png";
		$paths['Ubuntu'] = "/media/images/os/Ubuntu.png";
		$paths['Fedora'] = "/media/images/os/Fedora.png";
		$paths['CentOS'] = "/media/images/os/CentOS.png";
		$paths['Slackware'] = "/media/images/os/Slackware.png";
		$paths['Arch'] = "/media/images/os/Arch.png";
		$paths['Exherbo'] = "/media/images/os/Exherbo.png";
		$paths['Debian'] = "/media/images/os/Debian.png";
		$paths['FreeBSD'] = "/media/images/os/FreeBSD.png";
		$paths['OpenBSD'] = "/media/images/os/OpenBSD.png";
		$paths['NetBSD'] = "/media/images/os/NetBSD.png";
		$paths['DragonflyBSD'] = "/media/images/os/DragonflyBSD.png";
		$paths['ClockyOS'] = "/media/images/os/ClockyOS.png";
		$paths['Xbox'] = "/media/images/os/Xbox.png";
		$paths['Playstation'] = "/media/images/os/Playstation.png";
		$paths['Wii'] = "/media/images/os/Wii.png";
		$paths['Cisco CatOS'] = "/media/images/os/CiscoCatOS.png";
		$paths['Mac OS X'] = "/media/images/os/MacOSX.png";
		$paths['Solaris'] = "/media/images/os/Solaris.png";
		$paths['openSuSE'] = "/media/images/os/openSuSE.png";
		$paths['Red Hat Enterprise Linux'] = "/media/images/os/RedHatEnterpriseLinux.png";
		$paths['VMware ESX'] = "/media/images/os/VMwareESX.png";
		$paths['ChromeOS'] = "/media/images/os/ChromeOS.png";
		$paths['OpenWRT'] = "/media/images/os/OpenWRT.png";
		$paths['Vyatta'] = "/media/images/os/vyatta.png";
		$paths['Android'] = "/media/images/os/Android.png";
		$paths['GNU/Hurd'] = "/media/images/os/hurd.gif";
		$paths['RHEL'] = "/media/images/os/RHEL.png";
		$paths['Scientific'] = "/media/images/os/Scientific.png";
		$paths['VMware ESX(i)'] = "/media/images/os/vmwareesxi.png";
		$paths['Other'] = "/media/images/os/other.png";

		return $paths[$osname];
	}

    /**
     * Clean up a URL that has spaces in it to have %20's
     * @param $url  The URL to parse
     * @return string
     */
	//public function remove_url_space($url) {
	//	return preg_replace("/%20/"," ",$url);
	//}



    /**
     * Get the object of the current active system from $_SESSION
     * @return System
     */
	public function get_active_system() {
        // Check if the session was started
		if(session_id() == "") { 
			session_start();
		}

        // I have no idea why this works.
        require_once(APPPATH . "controllers/systems.php");
        if(!isset($_SESSION['activeSystem'])) {
            throw new ObjectNotFoundException("Could not find your system. Make sure you aren't pulling any URL shenanigans. Otherwise, click Systems on the left and start again.");
        }
		return unserialize($_SESSION['activeSystem']);
	}

    /**
     * Set the active system in $_SESSION
     * @param $sys  The system to set to
     * @return void
     */
	public function set_active_system($sys) {
        // Check if the session was started
		if(session_id() == "") { 
			session_start();
		}

        // Set it up!
		$_SESSION['activeSystem'] = serialize($sys);
	}
	
	/**
     * Get your username
     * @return string
     */
	public function get_username() {
		return $this->uname;
	}

	/**
	* Get the username that you are viewing as.
	* @todo: Make this do soemthing with the navbar field
	*/

    /**
     * Get your real name
     * @return string
     */
	public function get_name() {
		#return "$this->fname $this->lname";
		return $this->fullName;
	}
	
	public function hostname($string) {
		$string = strtolower($string);
		$string = preg_replace('/[^a-zA-Z0-9_]/','_',$string);
		return $string;
	}
	
	public function iseditable($object) {
		if($this->get_username() == $object->get_owner() || $this->CI->api->isadmin() == TRUE) {
			return true;
		}
		else {
			return null;
		}
	}

	public function prepareBlades($sys, $ifs) {
		switch($sys->get_platform()) {
			case 'Cisco 2960-48':
				$blades[0] = new Blade(48,4,2);
				$blades[1] = new Blade(2,4,2);

				foreach($ifs as $if) {
			          if(preg_match('/Gi|Fa/',$if->get_name())) {
			               #$bladeNum = preg_replace('/^(Gi|Fa)(\d)\/(.*?)$/','$2',$if->get_name());
     	     		     if(preg_match('/Gi/',$if->get_name())) { $bladeNum = 1; }
			               else { $bladeNum = 0; }
	          		     if($if->get_index() % 2 == 0) {
     	               		$blades[$bladeNum]->add_if($if, 1);
			               } else {
          			          $blades[$bladeNum]->add_if($if, 0);
		          	     }
	          		} else {
			               $otherIfs[] = $if;
          			}
				}
				break;
			case 'Cisco 2960-24':
				$blades[0] = new Blade(24,2,2);

				foreach($ifs as $if) {
			          if(preg_match('/Gi|Fa/',$if->get_name())) {
			               $bladeNum = preg_replace('/^(Gi|Fa)(\d)\/(.*?)$/','$2',$if->get_name());
     	     		     #if(preg_match('/Gi/',$if->get_name())) { $bladeNum = 1; }
			               #else { $bladeNum = 0; }
	          		     if($if->get_index() % 2 == 0) {
     	               		$blades[$bladeNum]->add_if($if, 1);
			               } else {
          			          $blades[$bladeNum]->add_if($if, 0);
		          	     }
	          		} else {
			               $otherIfs[] = $if;
          			}
				}
				break;
			case 'Cisco 6509-CSH':
				$blades[1] = new Blade(2,2,1);
				$blades[2] = new Blade(48,4,2);
				$blades[3] = new Blade(48,4,2);
				$blades[4] = new Blade(48,4,2);
				$blades[5] = new Blade(48,4,2);
				$blades[6] = new Blade(48,4,2);
				$blades[7] = new Blade(48,4,2);
				$blades[8] = new Blade(8,8,1);
				$blades[9] = new Blade(16,8,2);

				foreach($ifs as $if) {
			          if(preg_match('/Gi|Fa/',$if->get_name())) {
			               $bladeNum = preg_replace('/^(Gi|Fa)(\d)\/(.*?)$/','$2',$if->get_name());
						if($blades[$bladeNum]->get_port_groups() == $blades[$bladeNum]->get_int_count()) {
          			          $blades[$bladeNum]->add_if($if, 0);
						}
	          		     elseif($if->get_index() % 2 == 0) {
     	               		$blades[$bladeNum]->add_if($if, 1);
			               } else {
          			          $blades[$bladeNum]->add_if($if, 0);
		          	     }
	          		} else {
			               $otherIfs[] = $if;
          			}
				}
				break;
			case 'Cisco SF-300-24P':
				$blades[0] = new Blade(24, 12, 2);
				$blades[1] = new Blade(4, 2, 2);
				foreach($ifs as $if) {
			          if(preg_match('/fa/',$if->get_name())) {
			               #$bladeNum = preg_replace('/^(Gi|Fa)(\d)\/(.*?)$/','$2',$if->get_name());
     	     		     #if(preg_match('/Gi/',$if->get_name())) { $bladeNum = 1; }
			               #else { $bladeNum = 0; }
	          		     if($if->get_index() <= 12) {
     	               		$blades[0]->add_if($if, 0);
			               } else {
          			          $blades[0]->add_if($if, 1);
		          	     }
					} elseif (preg_match('/gi/',$if->get_name())) {
	          		     if($if->get_index() % 2 == 0) {
     	               		$blades[1]->add_if($if, 1);
			               } else {
          			          $blades[1]->add_if($if, 0);
						}
	          		} else {
			               $otherIfs[] = $if;
          			}
				}
				break;
			default:
				$blades = null;
				break;
		}

		return $blades;
	}
}
/* End of file Impulselib.php */
/* Location: ./application/libraries/Impulselib.php */
