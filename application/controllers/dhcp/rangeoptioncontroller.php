<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Rangeoptioncontroller extends ImpulseController {

	public function create($range) {
		// Decode
		$range = rawurldecode($range);

		// Range
		try {
			$r = $this->api->ip->get->range($range);
		}
		catch(Exception $e) { $this->_error($e); return; }

		// Create
		if($this->input->post()) {
			try {
				$opt = $this->api->dhcp->create->rangeoption(
					$r->get_name(),
					$this->_post('option'),
					$this->_post('value')
				);
				$this->_sendClient("/ip/range/view/".rawurlencode($r->get_name()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$content = $this->load->view('dhcp/option/create',null,true);

		$this->_renderSimple($content);
	}
	public function view($range, $option, $hash) {
		// Decode
		$range = rawurldecode($range);
		$option = rawurldecode($option);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$opt = $this->api->dhcp->get->rangeoptionByHash($range, $option, $hash);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Viewdata
		$viewData['opt'] = $opt;

		// Content
		$content = $this->load->view('dhcp/option/detail',$viewData,true);

		// Render
		$this->_renderSimple($content);
	}

	public function modify($range, $option, $hash) {
		// Decode
		$range = rawurldecode($range);
		$option = rawurldecode($option);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$opt = $this->api->dhcp->get->rangeoptionByHash($range, $option, $hash);
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

			$this->_sendClient("/ip/range/view/".rawurlencode($opt->get_range()));
		}

		// Viewdata
		$viewData['opt'] = $opt;

		// Content
		$content = $this->load->view('dhcp/option/modify',$viewData,true);

		// Render
		$this->_renderSimple($content);
	}

	public function remove($range, $option, $hash) {
		// Decode
		$range = rawurldecode($range);
		$option = rawurldecode($option);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$opt = $this->api->dhcp->get->rangeoptionByHash($range, $option, $hash);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->dhcp->remove->rangeoption(
					$opt->get_range(),
					$opt->get_option(),
					$opt->get_value()
				);

				$this->_sendClient("/ip/range/view/".rawurlencode($opt->get_range()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("No confirmation"));
			return;
		}
	}
}

/* End of file rangeoption.php */
/* Location: ./application/controllers/dhcp/rangeoption.php */
