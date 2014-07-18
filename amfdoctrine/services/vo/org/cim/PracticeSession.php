<?
namespace org\cim;

use Doctrine\Common\Collections\ArrayCollection;

class PracticeSession {
	// explicit ActionScript class
	public $_explicitType = "org.cim.PracticeSession";
	
	// table fields
	public $id;
	public $createdDate;
	public $lastAccessDate;
	public $lifecycle;
	
	// joined fields/objects
	public $user;
	
	public function setUser($user) {
		$user->addPracticeSession($this);
		$this->user = $user;
	}
	
	public function getUser() {
		return $this->user;
	}
	
	
	public $musicPiece;
	
	public function setMusicPiece($musicPiece) {
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
	
	
	public $settings = null;
	
	public function addSetting($setting) {
		$this->settings[] = $setting;
	}
	
	public function getSettings() {
		return $this->settings;
	}
	
	
	public $practiceRecordings = null;
	
	public function addPracticeRecording($practiceRecording) {
		$this->practiceRecordings[] = $practiceRecording;
	}
	
	public function getPracticeRecordings() {
		return $this->practiceRecordings;
	}
	
	public $annotations = null;
	
	public function addAnnotation($annotation) {
		$this->annotations[] = $annotation;
	}
	
	public function getAnnotations() {
		return $this->annotations;
	}
	
	// constructor
	public function __construct() {
		$this->settings = new ArrayCollection();
		$this->practiceRecordings = new ArrayCollection();
		$this->annotations = new ArrayCollection();
	}
}
?>