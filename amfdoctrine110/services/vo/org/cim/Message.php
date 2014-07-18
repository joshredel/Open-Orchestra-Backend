<?
namespace org\cim;

class Message {
	// explicit ActionScript class
	public $_explicitType = "org.cim.Message";
	
	// table fields
	public $id;
	public $subject;
	public $hasBeenRead;
	public $sentDate;
	public $openDate;
	public $deletedSenderFullName;
	
	// joined fields/objects
	public $setting;
	
	public function setSetting($setting) {
		$this->setting = $setting;
	}
	
	public function getSetting() {
		return $this->setting;
	}
	
	
	public $senderUser;
	
	public function setSenderUser($user) {
		$this->senderUser = $user;
	}
	
	public function getSenderUser() {
		return $this->senderUser;
	}
	
	
	public $receiverUser;
	
	public function setReceiverUser($user) {
		$this->receiverUser = $user;
	}
	
	public function getReceiverUser() {
		return $this->receiverUser = $user;
	}
	
	
	public $parentMessage;
	
	public function setParentMessage($message) {
		$this->parentMessage = $message;
	}
	
	public function getParentMessage() {
		return $this->parentMessage;
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