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
			$instruments = NULL;
			
			foreach($piece->scores as $score) {
				$score->instrument->load();
				if($score->defaultSetting) {
					$score->defaultSetting->load();
				}
				if($score->instrument->parentInstrument) {
					$score->instrument->parentInstrument->load();
				}
				
				// store all of the instruments
				$instruments[] = $score->instrument;
			}
			
			// generate the child instruments for the music piece
			$piece->scoreInstruments = new Doctrine\Common\Collections\ArrayCollection($instruments);
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
		
		// map incoming relations with their database entities
		$musicPiece->conductorUser = $entityManager->merge($musicPiece->conductorUser);
		for($i = 0; $i < count($musicPiece->scores); $i++) {
			$musicPiece->scores[$i] = $entityManager->merge($musicPiece->scores[$i]);
		}
		for($i = 0; $i < count($musicPiece->genres); $i++) {
			$musicPiece->genres[$i] = $entityManager->merge($musicPiece->genres[$i]);
		}
		
		// branch between creating a new music piece and updating an existing one
		if($musicPiece->id == 0) {
			// start managing this new music piece
			$entityManager->persist($musicPiece);
		} else {
			// merge this music piece so it is managed again and we can save
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
		
		// merge and then remove the entity
		$musicPiece = $entityManager->merge($musicPiece);
		$entityManager->remove($musicPiece);
		$entityManager->flush();
	}
}
?>