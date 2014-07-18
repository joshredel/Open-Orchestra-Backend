<?
namespace org\cim;

use Doctrine\Common\Collections\ArrayCollection;

class PracticeRecording {
	// explicit ActionScript class
	public $_explicitType = "org.cim.PracticeRecording";
	
	// table fields
	public $id;
	public $startLocation;
	public $stopLocation;
	public $fileName;
	public $recordingDate;
	public $duration;
	public $isUploaded;
	
	// joined fields/objects
	public $practiceSession;
	
	public function setPracticeSession($practiceSession) {
		$practiceSession->addPracticeRecording($this);
		$this->practiceSession = $practiceSession;
	}
	
	public function getPracticeSession() {
		return $this->practiceSession;
	}
	
	
	public $temporalComments = null;
	
	public function addTemporalComment($temporalComment) {
		$this->temporalComments[] = $temporalComment;
	}
	
	public function getTemporalComments() {
		return $this->temporalComments;
	}
	
	
	public $feedbacks = null;
	
	public function addFeedback($feedback) {
		$this->feedbacks[] = $feedback;
	}
	
	public function getFeedbacks() {
		return $this->feedbacks;
	}
	
	// constructor
	public function __construct() {
		$this->temporalComments = new ArrayCollection();
		$this->feedbacks = new ArrayCollection();
	}
}
?>