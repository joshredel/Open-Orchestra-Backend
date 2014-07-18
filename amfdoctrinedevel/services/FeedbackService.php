<?
class FeedbackService {
	public function getFeedbacks() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\Feedback u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$feedbacks = $query->getResult();
		
		return $feedbacks;
	}
	
	public function saveFeedback($feedback) {
		// stop if there was nothing passed
		if($feedback == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// map incoming relations to their corresponding database entities
		$feedback->content = $entityManager->merge($feedback->content); // check if this is necessary
		
		// branch between creating a new instrument or updating an existing one
		if($feedback->id == 0) {
			// start managing this new feedback
			$entityManager->persist($feedback);
		} else {
			// merge this feedback so it is managed again and we can save
			$entityManager->merge($feedback);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteFeedback($feedback) {
		// stop if there was nothing passed
		if($feedback == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$feedback = $entityManager->merge($feedback);
		$entityManager->remove($feedback);
		$entityManager->flush();
	}
}
?>