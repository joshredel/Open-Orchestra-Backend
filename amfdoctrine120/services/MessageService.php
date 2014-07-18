<?
class MessageService {
	public function getMessages() {
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// create the select query and execute
		$dql = "SELECT u FROM org\cim\Message u ORDER BY u.id ASC";
		$query = $entityManager->createQuery($dql);
		$messages = $query->getResult();
		
		return $messages;
	}
	
	public function saveMessage($message) {
		// stop if there was nothing passed
		if($message == NULL) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		require('/var/www/functions.php');
		
		// map incoming relations to their corresponding database entities
		// (check the necessity of doing one-to-one mappings (it might only be needed for many
		$message->setting = $entityManager->merge($message->setting);
		$message->senderUser = $entityManager->merge($message->senderUser);
		$message->receiverUser = $entityManager->merge($message->receiverUser);
		$message->parentMessage = $entityManager->merge($message->parentMessage);
		$message->content = $entityManager->merge($message->content);
		
		// branch between creating a new message or updating an existing one
		if($message->id == 0) {
			// start managing this new message
			$entityManager->persist($message);
		} else {
			// merge this message so it is managed again and we can save
			$entityManager->merge($message);
		}
		
		// carry out the awaiting operations
		$entityManager->flush();
	}
	
	public function deleteMessage($message) {
		// stop if there was nothing passed
		if($message == null) {
			return;
		}
		
		// bootstrap to doctrine
		require('../bootstrapper.php');
		
		// merge and then remove the entity
		$message = $entityManager->merge($message);
		$entityManager->remove($message);
		$entityManager->flush();
	}
}
?>