<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Grouprangecontroller extends ImpulseController {

	public function create($group) {
		// Decode
		$group = rawurldecode($group);

		// Instantiate
		try {
			$g = $this->api->get->group($group);
		}
		catch(Exception $e) { $this->_exit($e); return; }

		try {
			$rs = $this->api->ip->get->ranges();
		}	
		catch(ObjectNotFoundException $e) { $rs = array(); }
		catch(Exception $e) { $this->_exit($e); return; }

		if($this->input->post()) {
			try {
				$this->api->ip->create->rangegroup(
					$this->_post('range'),
					$this->_post('group')
				);
				$this->_sendClient("/group/view/".rawurlencode($g->get_group()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}

		$content = $this->load->view('grouprange/create',array('g'=>$g,'rs'=>$rs),true);
		$this->_renderSimple($content);
	}

	public function remove($group, $range) {
		// Decode
		$group = rawurldecode($group);
		$range = rawurldecode($range);

		// Instantiate
		try {
			$g  = $this->api->get->group($group);
			$r = $this->api->ip->get->range($range);
		}
		catch(Exception $e) { $this->_error($e); return; }

		if($this->input->post('confirm')) {
			try {
				$this->api->ip->remove->rangegroup($g->get_group(),$r->get_name());
				$this->_sendClient("/group/view/".rawurlencode($g->get_group()));
				return;
			}
			catch(Exception $e) { $this->_error($e); return; }
		}
		else {
			$this->_error(new Exception("no confirmation"));
			return;
		}
	}
}

/* End of file grouprangecontroller.php */
/* Location: ./application/controllers/grouprangecontroller.php */
