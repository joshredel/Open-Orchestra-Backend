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
		
		// update dates if neccessary
		if($feedback->id == 0) {
			// new feedback, set create date!
			$feedback->createdDate = new DateTime();
			
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
		
		// create the delete query and execute
		$dql = "DELETE org\cim\Feedback u WHERE u.id=" . $feedback->id;
		$query = $entityManager->createQuery($dql);
		$feedbacks = $query->getResult();
	}
}
?>