<?
namespace org\cim;

class Annotation {
	// explicit ActionScript class
	public $_explicitType = "org.cim.Annotation";
	
	// table fields
	public $id;
	public $fileLocation;
	
	// joined fields/objects
	public $practiceSession;
	
	public function setPracticeSession($practiceSession) {
		$practiceSession->addAnnotation($this);
		$this->practiceSession = $practiceSession;
	}
	
	public function getPracticeSession() {
		return $this->practiceSession;
	}
}
?>