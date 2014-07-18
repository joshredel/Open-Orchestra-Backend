<?
namespace org\cim;

use Doctrine\Common\Collections\ArrayCollection;

class User {
	// explicit ActionScript class
	public $_explicitType = "org.cim.User";
	
	// table fields
	public $id;
	public $firstName;
	public $lastName;
	public $password;
	public $rawPassword;
	public $institution;
	public $bio;
	public $email;
	public $createdDate;
	public $lastLoginDate;
	
	// joined fields/objects
	public $instruments = null;
	
	public function addInstrument($instrument) {
		$this->instruments[] = $instrument;
	}
	
	public function getInstruments() {
		return $this->instruments;
	}
//	public $instrument;
//	
//	public function setInstrument($instrument) {
//		$this->instrument = $instrument;
//	}
//	
//	public function getInstrument() {
//		return $this->instrument;
//	}
	
	
	public $practiceSessions = null;
	
	public function addPracticeSession($practiceSession) {
		$this->practiceSessions[] = $practiceSession;
	}
	
	public function getPracticeSessions() {
		return $this->practiceSessions;
	}
	
	
	public $roles = null;
	
	public function addRole($role) {
		$this->roles[] = $role;
	}
	
	public function getRoles() {
		return $this->roles;
	}
	
	// constructor
	public function __construct() {
		$this->instruments = new ArrayCollection();
		$this->practiceSessions = new ArrayCollection();
		$this->roles = new ArrayCollection();
	}
	
	public function load() {}
}
?>