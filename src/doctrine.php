<?php

$paths = [
    __DIR__ . '/Entity'
];

$isDevMode = true;

$cache = new \Doctrine\Common\Cache\ArrayCache();

$dbParams = [
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => '101010',
    'dbname' => 'son_doctrine_avanc_curso',
    'charset' => 'utf8'
];

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver($paths, false);
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir(__DIR__ . '/../proxy');
$config->setProxyNamespace('SON\Proxies');
$config->setAutoGenerateProxyClasses(true);

$em = \Doctrine\ORM\EntityManager::create($dbParams, $config);



$registry = new \SON\SimpleBaseManagerRegistry(
    static function ($id) use ($em) {
        switch ($id) {
            case 'default_connection':
                return $em->getConnection();
            case 'default_manager':
                return $em;
            default:
                throw new \RuntimeException(sprintf('Unknown service id "%s".', $id));
        }
    }
);

$serializer = JMS\Serializer\SerializerBuilder::create()
    ->setObjectConstructor(
        new \JMS\Serializer\Construction\DoctrineObjectConstructor(
            $registry,
            new \JMS\Serializer\Construction\UnserializeObjectConstructor(),
            \JMS\Serializer\Construction\DoctrineObjectConstructor::ON_MISSING_FALLBACK
        )
    )
    ->addDefaultHandlers()
    ->build();


function getEntityManager()
{
    global $em;
    return $em;
}