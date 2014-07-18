<?
class MusicPieceService {
	public function getMusicPieces() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\MusicPiece u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$musicPieces = $query->getResult();
		
		// TODO: remove this operation... it could become disgustingly expensive
		// loop through each music piece and touch its
		// instruments so that they are loaded!
		foreach($musicPieces as $piece) {
			foreach($piece->scores as $score) {
				$score->instrument->load();
				if($score->defaultSetting) {
					$score->defaultSetting->load();
				}
				if($score->instrument->parentInstrument) {
					$score->instrument->parentInstrument->load();
				}
			}
		}
		
		return $musicPieces;
	}
	
	public function saveMusicPiece($musicPiece) {
		// stop if there was nothing passed
		if($musicPiece == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// update dates if neccessary
		if($musicPiece->id == 0) {
			// new musicPiece, set create date!
			$musicPiece->createdDate = new DateTime();
			
			// start managing this new musicPiece
			$entityManager->persist($musicPiece);
		} else {
			// merge this musicPiece so it is managed again and we can save
			$entityManager->merge($musicPiece);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteMusicPiece($musicPiece) {
		// stop if there was nothing passed
		if($musicPiece == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the delete query and execute
		$dql = "DELETE org\cim\MusicPiece u WHERE u.id=" . $musicPiece->id;
		$query = $entityManager->createQuery($dql);
		$musicPieces = $query->getResult();
	}
}
?>