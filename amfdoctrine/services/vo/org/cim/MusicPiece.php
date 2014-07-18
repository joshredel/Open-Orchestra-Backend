<?
namespace org\cim;

use Doctrine\Common\Collections\ArrayCollection;

class MusicPiece {
	// explicit ActionScript class
	public $_explicitType = "org.cim.MusicPiece";
	
	// table fields
	public $id;
	public $pieceName;
	public $composer;
	public $performingEnsemble;
	public $recordedDate;
	public $conductorName;
	public $description;
	public $thumbnailSet;
	public $conductorsViewStream;
	
	// joined fields/objects
	public $conductorUser;
	
	public function setConductorUser($user) {
		$this->conductorUser = $user;
	}
	
	public function getConductorUser() {
		return $this->conductorUser;
	}
	
	
	public $scores = null;
	
	public function addScore($score) {
		$this->scores[] = $score;
	}
	
	public function getScores() {
		return $this->scores;
	}
	
	
	public $genres = null;
	
	public function addGenre($genre) {
		$this->genres[] = $genre;
	}
	
	public function getGenres() {
		return $this->genres;
	}
	
	// constructor
	public function __construct() {
		$this->scores = new ArrayCollection();
		$this->genres = new ArrayCollection();
	}
}
?>