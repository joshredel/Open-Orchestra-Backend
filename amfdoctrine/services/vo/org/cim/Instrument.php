<?
namespace org\cim;

class Instrument {
	// explicit ActionScript class
	public $_explicitType = "org.cim.Instrument";
	
	// table fields
	public $id;
	public $instrumentName;
	
	// joined fields/objects
	public $parentInstrument;
	
	public function setParentInstrument($message) {
		$this->parentInstrument = $message;
	}
	
	public function getParentInstrument() {
		return $this->parentInstrument;
	}
	
	
	public $childInstruments = null;
	
	public function addChildInstrument($instrument) {
		$this->childInstruments[] = $instrument;
	}
	
	public function getChildInstruments() {
		return $this->childInstruments;
	}
	
	
	public function load() {}
}
?>