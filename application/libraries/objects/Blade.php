<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blade {
	
	////////////////////////////////////////////////////////////////////////
	// MEMBER VARIABLES

	private $intCount;

	private $portGroups;

	private $rows;

	private $rowInts;

	private $portsPerGroup;
	
	////////////////////////////////////////////////////////////////////////
	// CONSTRUCTOR

    public function __construct($intCount, $portGroups, $rows) {
		// Object specific data
		$this->intCount = $intCount;
		$this->portGroups = $portGroups;
		$this->rows = $rows;

		$this->portsPerGroup = ($intCount / $rows) / $portGroups;

	}

	////////////////////////////////////////////////////////////////////////
	// GETTERS
	
	public function get_int_count() { return $this->intCount; }
	public function get_port_groups() { return $this->portGroups; }
	public function get_rows() {
		if($this->rowInts) {
			return array_keys($this->rowInts); 
		} else {
			return array();
		}
	}

	public function get_row($row) {
		return $this->rowInts[$row];
	}
	

    ////////////////////////////////////////////////////////////////////////
	// SETTERS

	public function add_if($if, $row) {
		$this->rowInts[$row][] = $if;
	}
	
    ////////////////////////////////////////////////////////////////////////
	// PUBLIC METHODS

	public function renderRow($rowNum) {
		$ifs = $this->rowInts[$rowNum];
		$html = "<div class=\"row-fluid\">";
		for($c=0; $c<$this->portGroups; $c++) {
			$spanCount = floor(12 / $this->portGroups);
			$html .= "<div class=\"span$spanCount\">";
			for($i=0; $i<$this->portsPerGroup; $i++) {
				if(!$ifs) { continue; }
				$currIf = array_shift($ifs);
				$spanCount = floor(12 / $this->portsPerGroup);
				$html .= "<div id=\"{$currIf->get_index()}\" class=\"span$spanCount switchport-div imp-switchport imp-".$currIf->get_css_class()."\"><a id=\"{$currIf->get_index()}-a\" class=\"switchport-link\" href=\"/network/switchport/view/".rawurlencode($currIf->get_system_name())."/".rawurlencode($currIf->get_index())."\"></a>{$currIf->get_number()}</div>";
			}
			$html .= "</div>";
		}
		$html .= "</div><br />";
		return $html;
	}
    
	////////////////////////////////////////////////////////////////////////
	// PRIVATE METHODS
}
/* End of file Blade.php */
/* Location: ./application/libraries/objects/Blade.php */
