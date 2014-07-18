<?
namespace org\cim;

use Doctrine\Common\Collections\ArrayCollection;

class Score {
	// explicit ActionScript class
	public $_explicitType = "org.cim.Score";
	
	// table fields
	public $id;
	public $fileLocation;
	public $xmlLocation;
	public $masterServerLocation;
	public $conversionServerLocation;
	public $stream;
	
	// joined fields/objects
	public $musicPiece;
	
	public function setMusicPiece($musicPiece) {
		$musicPiece->addScore($this);
		$this->musicPiece = $musicPiece;
	}
	
	public function getMusicPiece() {
		return $this->musicPiece;
	}
	
	
	public $instrument;
	
	public function setInstrument($instrument) {
		$this->instrument = $instrument;
	}
	
	public function getInstrument() {
		return $this->instrument;
	}
	
	
	public $defaultSetting;
	
	public function setDefaultSetting($setting) {
		$this->defaultSetting = $setting;
	}
	
	public function getDefaultSetting() {
		return $this->defaultSetting;
	}
	
	
	public $mixers = null;
	
	public function addMixer($mixer) {
		$this->mixers[] = $mixer;
	}
	
	public function getMixers() {
		return $this->mixers;
	}
	
	// constructor
	public function __construct() {
		$this->mixers = new ArrayCollection();
	}
}
?>