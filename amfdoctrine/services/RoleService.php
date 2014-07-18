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
		
		// update dates if neccessary
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
		
		// create the delete query and execute
		$dql = "DELETE org\cim\Role u WHERE u.id=" . $role->id;
		$query = $entityManager->createQuery($dql);
		$roles = $query->getResult();
	}
}
?>