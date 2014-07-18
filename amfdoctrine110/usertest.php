<?
require_once('bootstrapper.php');

$test = new org\cim\User();
$test->firstName = "\n----AutoLoading is working----\n\n";
echo $test->firstName;

$dql = "SELECT u FROM org\cim\User u";
//$dql = "SELECT u, i, p, r FROM org\cim\User u JOIN u.instruments i ";
//$dql .= "JOIN u.practiceSessions p JOIN u.roles r";
$query = $entityManager->createQuery($dql);
$users = $query->getResult();

foreach($users as $user) {
	print($user->firstName . " " . $user->lastName . "\n");
}

?>