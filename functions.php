<?
/**
 * Functions.php
 * 
 * Collection of standard functions used in all services.
 */

// database conection info
define("DATABASE_SERVER", "localhost");
define("DATABASE_USERNAME", "openorchestra");
define("DATABASE_PASSWORD", "8pY6pEWUKZYrRLXn");
define("DATABASE_NAME", "openorchestra");

/**
 * Connects to the database.
 */
function connect() {
	// connect to the database.
	$mysql = mysql_connect(DATABASE_SERVER, DATABASE_USERNAME, DATABASE_PASSWORD);
	mysql_select_db(DATABASE_NAME);
}

/**
 * In order to send data to Flex that can be translated via AMF
 * into an ActionScript value object, the data returned from the 
 * database must be converted to a PHP value object that has been 
 * mapped to the desired ActionScript VO.
 * This method essentially casts the untyped associative array 
 * returned from a database query to a PHP VO as notated in $arrTypes.
 */
function prepareForAMF($data, $arrTypes) {
	// return if the array has nothing in it
	if (count($data) == 0) {
		return $data;
	}
	
	// prepare for returning/recursion
	$ret = array();
	$substract = false;
	
	// look for the element marked "0", which is the 
	// "master" object that we are mapping to
	if (!array_key_exists('0', $data)) {
		// if we don't have it, then data is a subfield of 
		// the master object
		$data = array($data);
		$substract = true;
	}
	
	// loop through each piece of data from the original array
	for ($i = 0; $i < count($data); $i++) {
		// create a new object of type of that passed in $arrTypes[0]
		$o = new $arrTypes[0]();
		
		// loop through each property in the database returned current object
		foreach ($data[$i] as $property => $value) {
			// convert the case to camel case (later...)
			//$pproperty = strtolower($property);
			// we're skipping camel case for now, so this does nothing
			$pproperty = camelize($property);
			
			// if there is no such property in the PHP class, skip this
			if (!property_exists($o, $pproperty) && !($property == $arrTypes[0] . "ID")) {
				continue;
			}
			
			// if we find a foreign key attached item (e.g. a user's sessions)...
			if (array_key_exists($property, $arrTypes)) {
				// set it as an empty array if there is no data
				if ($value == NULL) {
					$o->$pproperty = array();
					continue;
				}
				
				// recursively prepare the sub-items
				// send the same types
				$newArr = $arrTypes;
				
				// but set the master type to the type of this sub-item
				$newArr[0] = $arrTypes[$property];
				
				// recurse!
				$o->$pproperty = prepareForAMF($value, $newArr);
			} else {
				// it's a "standard" field, so simply map it
				// but let's check if it's something specal
				if($property == $arrTypes[0] . "ID") {
					// it's an ID (e.g. UserID) and should be just id
					$o->id = $value;
				} else {
					$o->$pproperty = $value;
				}
			}
		}
		
		// at this item to be returned
		$ret[] = $o;
	}
    
	// not entirely sure...
	if ($substract) {
		$ret = $ret[0];
	}
    
	// we're done!
	return $ret;
}

/**
 * Helper function.
 * Converts a variable name to camelCase.
 * e.g. VariableName to variableName
 * Userful for changing VariableName style
 * database column names to camelCase style 
 * PHP/ActionScript field names.
 */
function camelize($varname) {
	return strtolower($varname[0]) . substr($varname, 1);
}

/**
 * Helper function
 * Converts a Flash-style "Unix" time (MILLIseconds since ...) 
 * into an actual Unix time (SECONDS since ...) and preprends 
 * the proper MySQL code to use it.
 */
function flashToMySQLDate($flashDate) {
	$newDate = $flashDate / 1000;
	return "FROM_UNIXTIME($newDate)";
}

/**
 * A collection of helper functions that simplify the 
 * get/add/edit/delete calls for the services.
 */
 /**
  * Gets all of the items in the table called 
  * [$className]s.  Sorts by the primary key.
  */
function getAll($className) {
	// connect to the database.
	connect();
	
	// retrieve all rows
	$query = "SELECT * FROM " . $className . "s ORDER BY " . $className . "ID;";
	$result = mysql_query($query);
	
	// cycle through each item found
	$items = array();
	while($row = mysql_fetch_object($result)) {
		$items[] = $row;
	}
	
	// free the result and return
	mysql_free_result($result);
	
	return $items;
}

function sendMail($body) {
	require_once('Mail.php');
	
	$from = "Josh Redel <joshua.redel@mail.mcgill.ca>";
	$to = "Josh Redel <joshredel@mac.com>";
	$subject = "OO Debug";
	
	$host = "ssl://smtp.mcgilleus.ca";
	$port = "465";
	$username = "vpcomm";
	$password = "739MfnYf";
	
	$headers = array ('From' => $from,
					  'To' => $to,
					  'Subject' => $subject);
	
	$smtp = Mail::factory('smtp',
				array ('host' => $host,
					   'port' => $port,
					   'auth' => true,
					   'username' => $username,
					   'password' => $password));
	
	$mail = $smtp->send($to, $headers, $body);
	
	/*if (PEAR::isError($mail)) {
		echo("<p>" . $mail->getMessage() . "</p>");
	} else {
		echo("<p>Message successfully sent!</p>");
	}*/
}

function sendTenMail($to, $subject, $body) {
	require_once('Mail.php');
	
	$from = "TeNconnect <ten@mcgilleus.ca>";
	
	$host = "ssl://smtp.mcgilleus.ca";
	$port = "465";
	$username = "vpcomm";
	$password = "jamvpcomm06";
	
	$headers = array ('From' => $from,
					  'To' => $to,
					  'Subject' => $subject);
	
	$smtp = Mail::factory('smtp',
				array ('host' => $host,
					   'port' => $port,
					   'auth' => true,
					   'username' => $username,
					   'password' => $password));
	
	$mail = $smtp->send($to, $headers, $body);
	
	/*if (PEAR::isError($mail)) {
		echo("<p>" . $mail->getMessage() . "</p>");
	} else {
		echo("<p>Message successfully sent!</p>");
	}*/
}

?>