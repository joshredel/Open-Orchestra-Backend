<?
namespace org\cim;

class Mixer {
	// explicit ActionScript class
	public $_explicitType = "org.cim.Mixer";
	
	// table fields
	public $id;
	public $sectionName;
	public $channelName;
	public $isReferenceInstrument;
	public $ordering;
	
	// joined fields/objects
	//public $musicPiece;
	public $score;
	
	public function setScore($score) {
		$score->addMixer($this);
		$this->score = $score;
	}
	
	public function getScore() {
		return $this->score;
	}
}
?>