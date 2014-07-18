<?
class PracticeSessionService {
	public function getPracticeSessions() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\PracticeSession u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$pracSessions = $query->getResult();
		
		return $pracSessions;
	}
	
	public function savePracticeSession($pracSession) {
		// stop if there was nothing passed
		if($pracSession == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// map incoming relations to their corresponding database entities
		$pracSession->user = $entityManager->merge($pracSession->user);
		$pracSession->musicPiece = $entityManager->merge($pracSession->musicPiece);
		$pracSession->instrument = $entityManager->merge($pracSession->instrument);
		for($i = 0; $i < count($pracSession->settings); $i++) {
			$pracSession->settings[$i] = $entityManager->merge($pracSession->settings[$i]);
		}
		for($i = 0; $i < count($pracSession->practiceRecordings); $i++) {
			$pracSession->practiceRecordings[$i] = $entityManager->merge($pracSession->practiceRecordings[$i]);
		}
		for($i = 0; $i < count($pracSession->annotations); $i++) {
			$pracSession->annotations[$i] = $entityManager->merge($pracSession->annotations[$i]);
		}
		
		// branch between creating a new practice session or upadating an existing one
		if($pracSession->id == 0) {
			// new user, set create date!
			$pracSession->createdDate = new DateTime();
			$pracSession->lastAccessDate = new DateTime();
			
			// start managing this new practice session
			$entityManager->persist($pracSession);
		} else {
			// save the last access time as now
			$pracSession->lastAccessDate = new DateTime();
			
			// merge this practice session so it is managed again and we can save
			$entityManager->merge($pracSession);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
		
		// return the merged/persisted entity
		$pracSession = $entityManager->merge($pracSession);
		foreach($pracSession->musicPiece->scores as $score) {
			// fully load the default setting
			$score->defaultSetting->load();
			
			// add to the collection of score instruments for the music piece
			$score->instrument->load();
			$instruments[] = $score->instrument;
		}
		
		// store the collection of score instruments
		$pracSession->musicPiece->scoreInstruments = new Doctrine\Common\Collections\ArrayCollection($instruments);
		
		return $pracSession;
	}
	
	public function deletePracticeSession($pracSession) {
		// stop if there was nothing passed
		if($pracSession == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$pracSession = $entityManager->merge($pracSession);
		$entityManager->remove($pracSession);
		$entityManager->flush();
	}
}
?>