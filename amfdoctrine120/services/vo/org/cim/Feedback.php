<?
namespace org\cim;

class Feedback {
	// explicit ActionScript class
	public $_explicitType = "org.cim.Feedback";
	
	// table fields
	public $id;
	public $hasBeenRead;
	public $sentDate;
	public $openDate;
	public $deletedAuthorFullName;
	public $kind;
	
	// joined fields/objects
	public $practiceRecording;
	
	public function setPracticeRecording($practiceRecording) {
		$practiceRecording->addFeedback($this);
		$this->practiceRecording = $practiceRecording;
	}
	
	public function getPracticeRecording() {
		return $this->practiceRecording;
	}
	
	
	public $authorUser;
	
	public function setAuthorUser($user) {
		$this->authorUser = $user;
	}
	
	public function getAuthorUser() {
		return $this->authorUser;
	}
	
	
	public $content;
	
	public function setContent($content) {
		$this->content = $content;
	}
	
	public function getContent() {
		return $this->content;
	}
}
?>