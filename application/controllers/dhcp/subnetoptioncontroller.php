<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Subnetoptioncontroller extends ImpulseController {

	public function create($subnet) {
		// Decode
		$subnet = rawurldecode($subnet);

		// Subnet
		try {
			$snet = $this->api->ip->get->subnet($subnet);
		}
		catch(Exception $e) { $this->_error($e); return; }

		// Create
		if($this->input->post()) {
			try {
				$opt = $this->api->dhcp->create->subnetoption(
					$snet->get_subnet(),
					$this->_post('option'),
					$this->_post('value')
				);
				$this->_sendClient("/ip/subnet/view/".rawurlencode($snet->get_subnet()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$content = $this->load->view('dhcp/option/create',null,true);

		$this->_renderSimple($content);
	}
	public function view($subnet, $option, $hash) {
		// Decode
		$subnet = rawurldecode($subnet);
		$option = rawurldecode($option);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$opt = $this->api->dhcp->get->subnetoptionByHash($subnet, $option, $hash);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Viewdata
		$viewData['opt'] = $opt;

		// Content
		$content = $this->load->view('dhcp/option/detail',$viewData,true);

		// Render
		$this->_renderSimple($content);
	}

	public function modify($subnet, $option, $hash) {
		// Decode
		$subnet = rawurldecode($subnet);
		$option = rawurldecode($option);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$opt = $this->api->dhcp->get->subnetoptionByHash($subnet, $option, $hash);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			$err = array();

			if($opt->get_option() != $this->_post('option')) {
				try { $opt->set_option($this->_post('option')); }
				catch (Exception $e) { $err[] = $e; }
			}
			if($opt->get_value() != $this->_post('value')) {
				try { $opt->set_value($this->_post('value')); }
				catch (Exception $e) { $err[] = $e; }
			}

			if($err) {
				$this->_error($err);
				return;
			}

			$this->_sendClient("/ip/subnet/view/".rawurlencode($opt->get_subnet()));
		}

		// Viewdata
		$viewData['opt'] = $opt;

		// Content
		$content = $this->load->view('dhcp/option/modify',$viewData,true);

		// Render
		$this->_renderSimple($content);
	}

	public function remove($subnet, $option, $hash) {
		// Decode
		$subnet = rawurldecode($subnet);
		$option = rawurldecode($option);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$opt = $this->api->dhcp->get->subnetoptionByHash($subnet, $option, $hash);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->dhcp->remove->subnetoption(
					$opt->get_subnet(),
					$opt->get_option(),
					$opt->get_value()
				);

				$this->_sendClient("/ip/subnet/view/".rawurlencode($opt->get_subnet()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("No confirmation"));
			return;
		}
	}
}

/* End of file subnetoption.php */
/* Location: ./application/controllers/dhcp/subnetoption.php */
