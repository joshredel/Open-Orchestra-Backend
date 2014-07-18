<?
// mark the application environment
define("APPLICATION_ENV", "development");

if(!isset($GLOBALS['autoloaderPrepared']) || $GLOBALS['autoloaderPrepared'] == false) {
	$GLOBALS['autoloaderPrepared'] = true;
	// setup the autoloader
	require 'Doctrine/Common/ClassLoader.php';
	$loader = new Doctrine\Common\ClassLoader("Doctrine", '/usr/share/php');
	$loader->register();
	
	//$loader = new Doctrine\Common\ClassLoader("org", __DIR__ . '/entities');
	$loader = new Doctrine\Common\ClassLoader("org", __DIR__ . '/services/vo');
	$loader->register();
}

$config = new Doctrine\ORM\Configuration();

// proxy configuration
$config->setProxyDir(__DIR__ . '/proxies');
$config->setProxyNamespace('org\cim\proxies');
$config->setAutoGenerateProxyClasses((APPLICATION_ENV == "development"));

// mapping configuration
$driverImpl = new Doctrine\ORM\Mapping\Driver\XmlDriver(__DIR__ . "/mappings");
$config->setMetadataDriverImpl($driverImpl);

// caching configuration
if (APPLICATION_ENV == "development") {
	$cache = new \Doctrine\Common\Cache\ArrayCache();
} else {
	$cache = new \Doctrine\Common\Cache\ApcCache();
}
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);

// database configuration parameters
$conn = array(
	'dbname' => 'openorchestradevel',
	'user' => 'openorchestradev',
	'password' => '7CFj5jEb9dcnpuhf',
	'host' => 'localhost',
	'driver' => 'pdo_mysql',
);

// obtaining the entity manager
$evm = new Doctrine\Common\EventManager();
$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config, $evm);
?>