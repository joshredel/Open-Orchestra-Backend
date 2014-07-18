<?
namespace org\cim;

class TemporalComment {
	// explicit ActionScript class
	public $_explicitType = "org.cim.TemporalComment";
	
	// table fields
	public $id;
	public $startLocation;
	public $stopLocation;
	public $commentDate;
	
	// joined fields/objects
	public $practiceRecording;
	
	public function setPracticeRecording($practiceRecording) {
		$practiceRecording->addTemporalComment($this);
		$this->practiceRecording = $practiceRecording;
	}
	
	public function getPracticeRecording() {
		return $this->practiceRecording;
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