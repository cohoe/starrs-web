<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Impulselib {

	private $fname;
	private $lname;
	private $uname;
	private $CI;

    /**
     *
     */
	function __construct() {
		$CI =& get_instance();
		$this->uname = $CI->input->server('WEBAUTH_USER');
		$this->fname = $CI->input->server('WEBAUTH_LDAP_GIVENNAME');
		$this->lname = $CI->input->server('WEBAUTH_LDAP_SN');
		#$this->uname = "user";
		#$this->fname = "Grant";
		#$this->lname = "Cohoe";
	}

    /**
     * @param $mac
     * @return
     */
	function get_eui64_address($mac)
	{
		return $mac;
	}

    /**
     * @param $osname
     * @return
     */
	function get_os_img_path($osname)
	{
		$paths['Arch'] = "media/images/os/Arch.jpg";
		$paths['CentOS'] = "media/images/os/CentOS.jpg";
		$paths['Cisco IOS'] = "media/images/os/Cisco IOS.jpg";
		$paths['Debian'] = "media/images/os/Debian.jpg";
		$paths['Exherbo'] = "media/images/os/Exherbo.jpg";
		$paths['Fedora'] = "media/images/os/Fedora.jpg";
		$paths['FreeBSD'] = "media/images/os/FreeBSD.jpg";
		$paths['Gentoo'] = "media/images/os/Gentoo.jpg";
		$paths['NetBSD'] = "media/images/os/NetBSD.jpg";
		$paths['OpenBSD'] = "media/images/os/OpenBSD.jpg";
		$paths['Slackware'] = "media/images/os/Slackware.jpg";
		$paths['Ubuntu'] = "media/images/os/Ubuntu.jpg";
		$paths['Windows 7'] = "media/images/os/Windows7.jpg";
		$paths['Windows Server 2003'] = "media/images/os/WindowsServer2003.jpg";
		$paths['Windows Server 2008'] = "media/images/os/WindowsServer2008.jpg";
		$paths['Windows Server 2008 R2'] = "media/images/os/WindowsServer2008R2.jpg";
		$paths['Windows Vista'] = "media/images/os/WindowsVista.jpg";
		$paths['Windows XP'] = "media/images/os/WindowsXP.jpg";
		$paths['Mac OS X'] = "media/images/os/MacOSX.jpg";

		return $paths[$osname];
	}

    /**
     * @param $url
     * @return mixed
     */
	public function remove_url_space($url) {
		return preg_replace("/%20/"," ",$url);
	}

    /**
     * @param $key
     * @param $value
     * @return void
     */
	public function set_session($key, $value) {
		session_start();
		$_SESSION[$key] = $value;
	}

    /**
     * @param $key
     * @return
     */
	public function get_session($key) {
		session_start();
		return $_SESSION[$key];
	}

    /**
     * @param $key
     * @return void
     */
	public function clear_session($key) {
		session_start();
		unset($_SESSION[$key]);
	}

    /**
     * @return
     */
	public function get_username() {
		return $this->uname;
	}

    /**
     * @return string
     */
	public function get_name() {
		return "$this->fname $this->lname";
	}

	public function get_active_system() {
		if(session_id() == "") { 
			session_start();
		}

        // I have no idea why this works.
        require_once(APPPATH . "controllers/systems.php");
		return unserialize($_SESSION['activeSystem']);
	}

	public function set_active_system($sys) {
		if(session_id() == "") { 
			session_start();
		}

		$_SESSION['activeSystem'] = serialize($sys);
	}

	public function add_active_interface($int) {
		if(session_id() == "") { 
			session_start();
		}

		$_SESSION['interfaces'][$int->get_mac()] = serialize($int);
	}

//	public function get_active_interface($mac) {
//		if(session_id() == "") {
//			session_start();
//		}
//
//		# I have absolutely no idea why this works... or is necessary
//		require_once(APPPATH . "controllers/systems.php");
//		return unserialize($_SESSION['interfaces'][$mac]);
//	}
	
}

/* End of file Impulselib.php */
