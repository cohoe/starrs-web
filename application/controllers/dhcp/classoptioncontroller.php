<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Classoptioncontroller extends ImpulseController {

	public function create($class) {
		// Decode
		$class = rawurldecode($class);

		// Class
		try {
			$c = $this->api->dhcp->get->_class($class);
		}
		catch(Exception $e) { $this->_error($e); return; }

		// Create
		if($this->input->post()) {
			try {
				$opt = $this->api->dhcp->create->classoption(
					$c->get_class(),
					$this->_post('option'),
					$this->_post('value')
				);
				$this->_sendClient("/dhcp/class/view/".rawurlencode($c->get_class()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$content = $this->load->view('dhcp/option/create',null,true);

		$this->_renderSimple($content);
	}
	public function view($class, $option, $hash) {
		// Decode
		$class = rawurldecode($class);
		$option = rawurldecode($option);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$opt = $this->api->dhcp->get->classoptionByHash($class, $option, $hash);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		// Viewdata
		$viewData['opt'] = $opt;

		// Content
		$content = $this->load->view('dhcp/option/detail',$viewData,true);

		// Render
		$this->_renderSimple($content);
	}

	public function modify($class, $option, $hash) {
		// Decode
		$class = rawurldecode($class);
		$option = rawurldecode($option);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$opt = $this->api->dhcp->get->classoptionByHash($class, $option, $hash);
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

			$this->_sendClient("/dhcp/class/view/".rawurlencode($opt->get_class()));
			return;
		}

		// Viewdata
		$viewData['opt'] = $opt;

		// Content
		$content = $this->load->view('dhcp/option/modify',$viewData,true);

		// Render
		$this->_renderSimple($content);
	}

	public function remove($class, $option, $hash) {
		// Decode
		$class = rawurldecode($class);
		$option = rawurldecode($option);
		$hash = rawurldecode($hash);

		// Instantiate
		try {
			$opt = $this->api->dhcp->get->classoptionByHash($class, $option, $hash);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->dhcp->remove->classoption(
					$opt->get_class(),
					$opt->get_option(),
					$opt->get_value()
				);

				$this->_sendClient("/dhcp/class/view/".rawurlencode($opt->get_class()));
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("No confirmation"));
			return;
		}
	}
}

/* End of file classoption.php */
/* Location: ./application/controllers/dhcp/classoption.php */
