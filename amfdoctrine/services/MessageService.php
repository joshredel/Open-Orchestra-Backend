<?
class UserService {
	public function getUsers() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\User u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$users = $query->getResult();
		
		return $users;
	}
	
	public function saveUser($user) {
		// stop if there was nothing passed
		if($user == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// update dates if neccessary
		if($user->id == 0) {
			// new user, set create date!
			$user->createdDate = new DateTime();
			
			// start managing this new user
			$entityManager->persist($user);
		} else {
			// merge this user so it is managed again and we can save
			$entityManager->merge($user);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteUser($user) {
		// stop if there was nothing passed
		if($user == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the delete query and execute
		$dql = "DELETE org\cim\User u WHERE u.id=" . $user->id;
		$query = $entityManager->createQuery($dql);
		$users = $query->getResult();
	}
}
?>