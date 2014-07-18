<?
class AnnotationService {
	public function getAnnotations() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\Annotation u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$annotations = $query->getResult();
		
		return $annotations;
	}
	
	public function saveAnnotation($annotation) {
		// stop if there was nothing passed
		if($annotation == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// update dates if neccessary
		if($annotation->id == 0) {
			// start managing this new annotation
			$entityManager->persist($annotation);
		} else {
			// merge this annotation so it is managed again and we can save
			$entityManager->merge($annotation);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteAnnotation($annotation) {
		// stop if there was nothing passed
		if($annotation == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the delete query and execute
		$dql = "DELETE org\cim\Annotation u WHERE u.id=" . $annotation->id;
		$query = $entityManager->createQuery($dql);
		$annotations = $query->getResult();
	}
}
?>