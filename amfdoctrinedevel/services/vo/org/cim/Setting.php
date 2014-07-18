<?
namespace org\cim;

class Setting {
	// explicit ActionScript class
	public $_explicitType = "org.cim.Setting";
	
	// table fields
	public $id;
	public $settingName;
	public $startingPoint;
	public $endingPoint;
	public $mixerData;
	
	// joined fields/objects
	public $practiceSession;
	
	public function setPracticeSession($practiceSession) {
		$practiceSession->addSetting($this);
		$this->practiceSession = $practiceSession;
	}
	
	public function getPracticeSession() {
		return $this->practiceSession;
	}
	
	
	public function load() {}
}
?>