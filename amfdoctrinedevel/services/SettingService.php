<?
class SettingService {
	public function getSettings() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\Setting u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$settings = $query->getResult();
		
		return $settings;
	}
	
	public function saveSetting($setting) {
		// stop if there was nothing passed
		if($setting == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// map incoming relations to their corresponding database entities
		if($setting->practiceSession != NULL) {
			$setting->practiceSession = $entityManager->merge($setting->practiceSession);
		}
		
		// branch between creating a new setting or updating an existing one
		if($setting->id == 0) {
			// start managing this new setting
			$entityManager->persist($setting);
		} else {
			// merge this setting so it is managed again and we can save
			$entityManager->merge($setting);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
		
		// merge the just saved setting so we can return it
		$setting = $entityManager->merge($setting);
		return $setting;
	}
	
	public function deleteSetting($setting) {
		// stop if there was nothing passed
		if($setting == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$setting = $entityManager->merge($setting);
		$entityManager->remove($setting);
		$entityManager->flush();
	}
	
	/**
	 * Finds all settings made for a particular score by a user.
	 * Extracts necessary information from the passed practice session.
	 */
	public function getAllScoreSettings($pracSession) {
		if($pracSession == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// get all practice sessions
		$dql = "SELECT u FROM org\cim\PracticeSession u";
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
					foreach($currentSession->settings as $setting) {
						$settings[] = $setting;
					}
			}
		}
		
		// return the setings
		return $settings;
	}
}
?>