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
	
	public function attemptLogin($password) {
		// stop if there was nothing passed
		if($password == null) {
			return null;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// search for the user
		$dql = "SELECT u FROM org\cim\User u WHERE u.password='$password'";
		$query = $entityManager->createQuery($dql);
		$users = $query->getResult();
		
		// return the user only if it is unique
		if(sizeof($users) != 1) {
			return null;
		} else {
			// store the last login date
			$users[0]->lastLoginDate = new DateTime();
			$entityManager->merge($users[0]);
			$entityManager->flush();
			
			return $users[0];
		}
	}
	
	public function saveUserOld($user, $instrumentId) {
		//DEPRECATED!
		// pushing the call to the other function
		saveUser($user);
//		// stop if there was nothing passed
//		if($user == NULL) {
//			return null;
//		}
//		
//		// bootstrap to doctrine
//		require('../bootstrapper.php');
//		require('/var/www/functions.php');
//		
//		// convert the array from Flex into an ArrayCollection
//		//$user->instruments = new Doctrine\Common\Collections\ArrayCollection($user->instruments);
////		// since saving instruments doesn't seem to work... we'll do it manually.
////		// create a new array to hold what we find
////		$instruments = new Doctrine\Common\Collections\ArrayCollection();
////		
////		// go through each sent instrument and save manually
////		foreach($user->instruments as $instrument) {
////			// find this instrument in the database
////			$dql = "SELECT u FROM org\cim\Instrument u WHERE u.id=" . $instrument->id;
////			$query = $entityManager->createQuery($dql);
////			$found = $query->getResult();
////			
////			// add it to the list
////			$instruments[] = $found;
////		}
//		
//		// update dates if neccessary
//		if($user->id == 0) {
//			// make sure nothing already exists with the same username and password
//			// search for a user with the same password as we entered
//			$dql = "SELECT u FROM org\cim\User u WHERE u.password='" . $user->password . "'";
//			$query = $entityManager->createQuery($dql);
//			$users = $query->getResult();
//			
//			// end here if there is already a user with that password
//			if(sizeof($users) > 0) {
//				return null;
//			}
//			
//			// new user, set create date!
//			$user->createdDate = new DateTime();
//			
//			// manually save the instrument
//			$user->instruments = new Doctrine\Common\Collections\ArrayCollection();
//			
//			$dql = "SELECT u FROM org\cim\Instrument u WHERE u.id=$instrumentId";
//			$query = $entityManager->createQuery($dql);
//			$instruments = $query->getResult();
//			
//			$user->instruments[] = $instruments[0];
//			
//			// start managing this new user
//			$entityManager->persist($user);
//		} else {
//			// merge this user so it is managed again and we can save
//			$entityManager->merge($user);
//		}
//		
//		// carry out the awaiting operations
//		$entityManager->flush();
//		
//		return $user;
	}
	
	public function saveUser($user) {
		// stop if there was nothing passed
		if($user == NULL) {
			return null;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// map the incoming relations to their corresponing database entities
		for($i = 0; $i < count($user->instruments); $i++) {
			$user->instruments[$i] = $entityManager->merge($user->instruments[$i]);
		}
		for($i = 0; $i < count($user->roles); $i++) {
			$user->roles[$i] = $entityManager->merge($user->roles[$i]);
		}
		
		// update dates if neccessary
		if($user->id == 0) {
			// make sure nothing already exists with the same password
			// search for a user with the same password as we entered
			$dql = "SELECT u FROM org\cim\User u WHERE u.password='" . $user->password . "'";
			$query = $entityManager->createQuery($dql);
			$users = $query->getResult();
			
			// end here if there is already a user with that password
			if(sizeof($users) > 0) {
				return null;
			}
			
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
		
		// return the saved user, if the client happens to want it
		return $user;
	}
	
	public function deleteUser($user) {
		// stop if there was nothing passed
		if($user == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$user = $entityManager->merge($user);
		$entityManager->remove($user);
		$entityManager->flush();
	}
}
?>