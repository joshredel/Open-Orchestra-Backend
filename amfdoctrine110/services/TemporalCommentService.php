<?
class TemporalCommentService {
	public function getTemporalComments() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\TemporalComment u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$temporalComments = $query->getResult();
		
		return $temporalComments;
	}
	
	public function saveTemporalComments($tempComment) {
		// stop if there was nothing passed
		if($tempComment == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// map the incoming relations to their corresponding database entities
		$tempComment->content = $entityManager->merge($tempComment->content);
		
		// branch on creating a new temporal comment or updating an existing one
		if($tempComment->id == 0) {
			// start managing this new temporal comment
			$entityManager->persist($tempComment);
		} else {
			// merge this temporal comment so it is managed again and we can save
			$entityManager->merge($tempComment);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteTemporalComment($tempComment) {
		// stop if there was nothing passed
		if($tempComment == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$tempComment = $entityManager->merge($tempComment);
		$entityManager->remove($tempComment);
		$entityManager->flush();
	}
}
?>