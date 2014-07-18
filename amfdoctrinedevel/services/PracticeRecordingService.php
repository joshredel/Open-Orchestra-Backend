<?
class PracticeRecordingService {
	public function getPracticeRecording() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\User u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$pracRecordings = $query->getResult();
		
		return $pracRecordings;
	}
	
	public function savePracticeRecording($pracRecording) {
		// stop if there was nothing passed
		if($pracRecording == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// map incoming relations to their corresponding database entities
		if($pracRecording->practiceSession != NULL) {
			$pracRecording->practiceSession = $entityManager->merge($pracRecording->practiceSession);
		}
		for($i = 0; $i < count($pracRecording->temporalComments); $i++) {
			$pracRecording->temporalComments[$i] = $entityManager->merge($pracRecording->temporalComments[$i]);
		}
		for($i = 0; $i < count($pracRecording->feedbacks); $i++) {
			$pracRecording->feedbacks[$i] = $entityManager->merge($pracRecording->feedbacks[$i]);
		}
		
		// branch between creating a new practice recording and updating an existing one
		if($pracRecording->id == 0) {
			// set the recording date to the save time... remove later once timezones have been worked out
			$pracRecording->recordingDate = new DateTime();
			
			// start managing this new practice recording
			$entityManager->persist($pracRecording);
		} else {
			// set the recording date to the save time... remove later once timezones have been worked out
			$pracRecording->recordingDate = new DateTime();
			
			// merge this practice recording so it is managed again and we can save
			$entityManager->merge($pracRecording);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
		
		// return the merged/persisted entity
		$pracRecording = $entityManager->merge($pracRecording);
		return $pracRecording;
	}
	
	public function deletePracticeRecording($pracRecording) {
		// stop if there was nothing passed
		if($pracRecording == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$pracRecording = $entityManager->merge($pracRecording);
		$entityManager->remove($pracRecording);
		$entityManager->flush();
	}
	
	/**
	 * Finds all practice recordings made for a particular score by a user.
	 * Extracts necessary information from the passed practice session.
	 */
	public function getAllScoreRecordings($pracSession) {
		if($pracSession == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// get all practice sessions
		$dql = "SELECT u FROM org\cim\PracticeSession u ORDER BY u.id DESC";
		$query = $entityManager->createQuery($dql);
		$allSessions = $query->getResult();
		
		// get the merged version of the practice session
		$pracSession = $entityManager->merge($pracSession);
		
		// now loop through them and see if they fit our needs
		foreach($allSessions as $currentSession) {
			if($currentSession->user == $pracSession->user &&
			   $currentSession->musicPiece == $pracSession->musicPiece &&
			   $currentSession->instrument == $pracSession->instrument) {
					// it matches the criteria, so let's add its settings to our collection for returning
					foreach($currentSession->practiceRecordings as $recording) {
						$recordings[] = $recording;
					}
			}
		}
		
		// return the recordings
		return $recordings;
	}
}
?>