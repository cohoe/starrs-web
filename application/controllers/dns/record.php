<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . "libraries/core/ImpulseController.php");

class Record extends ImpulseController {

	public function __construct() {
		parent::__construct();
		$this->_setNavHeader("DNS");
	}

	public function create($recType=null) {
		
		#$this->_addScript('/js/impulse.js');
		#$this->_addScript('/js/dns.js');

		if(!$recType) {
			$recTypes = $this->api->dns->get->recordtypes();
			$this->load->view('dns/recordselect',array('types'=>$recTypes));
			return;
		}

		if($this->input->post()) {
			if($this->input->post('ttl') == "") {
				$ttl = null;
			}
			else {
				$ttl = $this->input->post('ttl');
			}
			switch($recType) {
				case 'A':
					$aRec = $this->api->dns->create->address(
						$this->input->post('address'),
						$this->input->post('hostname'),
						$this->input->post('zone'),
						$ttl,
						$this->input->post('owner')
					);
		return $this->_sendClient("/dns/records/view/".rawurlencode($aRec->get_address()),true);
					break;
				default:
					print "FOOBAR";
					break;
			}
		}

		$zones = $this->api->dns->get->zonesByUser($this->user->getActiveUser());

		switch($recType) {
			case 'A':
				$content = $this->load->view('dns/a/create',array('zones'=>$zones,'user'=>$this->user),true);
				break;
			default:
				print "Foo";
				break;
		}

		$this->_renderSimple($content);
	}

	private function _create($recType) {

		switch($recType) {
			case 'A':
				#try {
					$rec = $this->api->dns->create->address(
						$this->input->post('address'),
						$this->input->post('hostname'),
						$this->input->post('zone'),
						$ttl,
						$this->input->post('owner')
					);
					die($rec);
				#}
				#catch (Exception $e) { die("here"); return $this->_error($e); }
				break;
			default:
				print "LOLWAT";
				break;
		}

		#return $this->_sendClient("/dns/records/view/".rawurlencode($rec->get_address()),true);
	}
}
/* End of file record.php */
/* Location: ./application/controllers/dns/record.php */
