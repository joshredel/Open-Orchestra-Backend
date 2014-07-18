<?
class GenreService {
	public function getGenres() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\Genre u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$genres = $query->getResult();
		
		return $genres;
	}
	
	public function saveGenre($genre) {
		// stop if there was nothing passed
		if($genre == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// update dates if neccessary
		if($genre->id == 0) {
			// start managing this new genre
			$entityManager->persist($genre);
		} else {
			// merge this genre so it is managed again and we can save
			$entityManager->merge($genre);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteGenre($genre) {
		// stop if there was nothing passed
		if($genre == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the delete query and execute
		$dql = "DELETE org\cim\Genre u WHERE u.id=" . $genre->id;
		$query = $entityManager->createQuery($dql);
		$genres = $query->getResult();
	}
}
?>