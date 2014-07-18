<?
class ScoreService {
	public function getScores() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\Score u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$scores = $query->getResult();
		
		// load the sub components
		foreach($scores as $score) {
			$score->instrument->load();
			if($score->defaultSetting) {
				$score->defaultSetting->load();
			}
		}
		
		return $scores;
	}
	
	public function saveScore($score) {
		// stop if there was nothing passed
		if($score == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// update dates if neccessary
		if($score->id == 0) {
			// start managing this new score
			$entityManager->persist($score);
		} else {
			// merge this score so it is managed again and we can save
			$entityManager->merge($score);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteScore($score) {
		// stop if there was nothing passed
		if($score == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the delete query and execute
		$dql = "DELETE org\cim\Score u WHERE u.id=" . $score->id;
		$query = $entityManager->createQuery($dql);
		$scores = $query->getResult();
	}
}
?>