<?
class InstrumentService {
	public function getInstruments() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT i FROM org\cim\Instrument i ORDER BY i.id ASC";
		$query = $entityManager->createQuery($dql);
		$instruments = $query->getResult();
		
		return $instruments;
	}
	
	public function getParentInstruments() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT i FROM org\cim\Instrument i WHERE i.parentInstrument IS NULL ORDER BY i.id ASC";
		$query = $entityManager->createQuery($dql);
		$instruments = $query->getResult();
		
		return $instruments;
	}
	
	public function saveInstrument($instrument) {
		// stop if there was nothing passed
		if($instrument == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// update dates if neccessary
		if($instrument->id == 0) {
			// new instrument, set create date!
			$instrument->createdDate = new DateTime();
			
			// start managing this new instrument
			$entityManager->persist($instrument);
		} else {
			// merge this instrument so it is managed again and we can save
			$entityManager->merge($instrument);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteInstrument($instrument) {
		// stop if there was nothing passed
		if($instrument == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the delete query and execute
		$dql = "DELETE org\cim\Instrument u WHERE u.id=" . $instrument->id;
		$query = $entityManager->createQuery($dql);
		$instruments = $query->getResult();
	}
}
?>