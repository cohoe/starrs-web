<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Statistics extends CI_Controller {
	
	public function index() {
		
		// Information
		$navOptions = array("OS Distribution"=>'os_distribution',"OS Family Distribution"=>'os_family_distribution');
		$navbar = new Navbar("Statistics",FALSE,FALSE,FALSE,NULL,"/statistics",$navOptions);
		
		// Load view data
		$info['header'] = $this->load->view('core/header',"",TRUE);
		$info['sidebar'] = $this->load->view('core/sidebar',"",TRUE);
		$info['navbar'] = $this->load->view('core/navbar',array("navbar"=>$navbar),TRUE);
		$info['data'] = $this->load->view('statistics/getstarted',array(),TRUE);
		$info['title'] = "Statistics";
		
		// Load the main view
		$this->load->view('core/main',$info);
	}			
	
	public function os_distribution() {
		$data = $this->api->systems->get_os_distribution();
		
		// Information
		$navOptions = array("OS Distribution"=>'os_distribution',"OS Family Distribution"=>'os_family_distribution');
		$navbar = new Navbar("OS Distribution",FALSE,FALSE,FALSE,NULL,"/statistics",$navOptions);
		
		// Load view data
		$info['header'] = $this->load->view('core/header',"",TRUE);
		$info['sidebar'] = $this->load->view('core/sidebar',"",TRUE);
		$info['navbar'] = $this->load->view('core/navbar',array("navbar"=>$navbar),TRUE);
		$info['data'] = $this->load->view('statistics/os_distribution',array("data"=>$data),TRUE);
		$info['title'] = "OS Distribution";
		
		// Load the main view
		$this->load->view('core/main',$info);
	}
	
	public function os_family_distribution() {
		$data = $this->api->systems->get_os_family_distribution();
		
		// Information
		$navOptions = array("OS Distribution"=>'os_distribution',"OS Family Distribution"=>'os_family_distribution');
		$navbar = new Navbar("OS Family Distribution",FALSE,FALSE,FALSE,NULL,"/statistics",$navOptions);
		
		// Load view data
		$info['header'] = $this->load->view('core/header',"",TRUE);
		$info['sidebar'] = $this->load->view('core/sidebar',"",TRUE);
		$info['navbar'] = $this->load->view('core/navbar',array("navbar"=>$navbar),TRUE);
		$info['data'] = $this->load->view('statistics/os_family_distribution',array("data"=>$data),TRUE);
		$info['title'] = "OS Family Distribution";
		
		// Load the main view
		$this->load->view('core/main',$info);
	}
}