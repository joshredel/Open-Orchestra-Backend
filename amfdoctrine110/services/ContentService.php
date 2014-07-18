<?
class ContentService {
	public function getContents() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\Content u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$contents = $query->getResult();
		
		return $contents;
	}
	
	public function saveContent($content) {
		// stop if there was nothing passed
		if($content == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// branch between creating a new instrument or updating an existing one
		if($content->id == 0) {
			// start managing this new content
			$entityManager->persist($content);
		} else {
			// merge this content so it is managed again and we can save
			$entityManager->merge($content);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteContent($content) {
		// stop if there was nothing passed
		if($content == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$content = $entityManager->merge($content);
		$entityManager->remove($content);
		$entityManager->flush();
	}
}
?>