<?
class RoleService {
	public function getRoles() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\Role u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$roles = $query->getResult();
		
		return $roles;
	}
	
	public function saveRole($role) {
		// stop if there was nothing passed
		if($role == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// map the incoming relations to their corresponding database entities
		//TODO
		
		// branch between creating a new role and updating an existing one
		if($role->id == 0) {
			// start managing this new role
			$entityManager->persist($role);
		} else {
			// merge this role so it is managed again and we can save
			$entityManager->merge($role);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteRole($role) {
		// stop if there was nothing passed
		if($role == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$role = $entityManager->merge($role);
		$entityManager->remove($role);
		$entityManager->flush();
	}
}
?>