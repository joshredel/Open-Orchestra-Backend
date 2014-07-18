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
			// load the instrument and default setting and music piece
			$score->instrument->load();
			if($score->defaultSetting) {
				$score->defaultSetting->load();
			}
			$score->musicPiece->load();
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
		
		// map incoming relations to their corresponding database entities
		$score->instrument = $entityManager->merge($score->instrument);
		$score->defaultSetting = $entityManager->merge($score->defaultSetting);
		for($i = 0; $i < count($score->mixers); $i++) {
			$score->mixers[$i] = $entityManager->merge($score->mixers[$i]);
		}
		
		// branch between creating a new score and updating an exisitng one
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
}
?>