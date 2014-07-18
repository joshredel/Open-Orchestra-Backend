<?
class MixerService {
	public function getMixers() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\Mixer u ORDER BY u.ordering ASC";
		$query = $entityManager->createQuery($dql);
		$mixers = $query->getResult();
		
		return $mixers;
	}
	
	public function saveMixer($mixer) {
		// stop if there was nothing passed
		if($mixer == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// branch between creating a new mixer and updating an existing one
		if($mixer->id == 0) {
			// start managing this new mixer
			$entityManager->persist($mixer);
		} else {
			// merge this mixer so it is managed again and we can save
			$entityManager->merge($mixer);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteMixer($mixer) {
		// stop if there was nothing passed
		if($mixer == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$mixer = $entityManager->merge($mixer);
		$entityManager->remove($mixer);
		$entityManager->flush();
	}
}
?>