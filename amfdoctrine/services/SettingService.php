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
		
		// update dates if neccessary
		if($setting->id == 0) {
			// new setting, set create date!
			$setting->createdDate = new DateTime();
			
			// start managing this new setting
			$entityManager->persist($setting);
		} else {
			// merge this setting so it is managed again and we can save
			$entityManager->merge($setting);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteSetting($setting) {
		// stop if there was nothing passed
		if($setting == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the delete query and execute
		$dql = "DELETE org\cim\Setting u WHERE u.id=" . $setting->id;
		$query = $entityManager->createQuery($dql);
		$settings = $query->getResult();
	}
}
?>