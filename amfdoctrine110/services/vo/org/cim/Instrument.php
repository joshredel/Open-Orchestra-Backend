<?
namespace org\cim;

use Doctrine\Common\Collections\ArrayCollection;

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
	
	// constructor
	public function __construct() {
		$this->childInstruments = new ArrayCollection();
	}
	
	public function load() {}
}
?>