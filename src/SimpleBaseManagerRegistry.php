<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 10/03/2019
 * Time: 12:58
 */

namespace SON;


use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\ORM\ORMException;

class SimpleBaseManagerRegistry extends AbstractManagerRegistry
{
    private $services = [];
    private $serviceCreator;
    public function __construct($serviceCreator, $name = 'anonymous', array $connections = ['default' => 'default_connection'], array $managers = ['default' => 'default_manager'], $defaultConnection = null, $defaultManager = null, $proxyInterface = 'Doctrine\Common\Persistence\Proxy')
    {
        if (null === $defaultConnection) {
            $defaultConnection = key($connections);
        }
        if (null === $defaultManager) {
            $defaultManager = key($managers);
        }
        parent::__construct($name, $connections, $managers, $defaultConnection, $defaultManager, $proxyInterface);
        if (!is_callable($serviceCreator)) {
            throw new \InvalidArgumentException('$serviceCreator must be a valid callable.');
        }
        $this->serviceCreator = $serviceCreator;
    }
    public function getService($name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }
        return $this->services[$name] = call_user_func($this->serviceCreator, $name);
    }
    public function resetService($name)
    {
        unset($this->services[$name]);
    }
    public function getAliasNamespace($alias)
    {
        foreach (array_keys($this->getManagers()) as $name) {
            $manager = $this->getManager($name);
            if ($manager instanceof EntityManager) {
                try {
                    return $manager->getConfiguration()->getEntityNamespace($alias);
                } catch (ORMException $ex) {
                    // Probably mapped by another entity manager, or invalid, just ignore this here.
                }
            } else {
                throw new \LogicException(sprintf('Unsupported manager type "%s".', get_class($manager)));
            }
        }
        throw new \RuntimeException(sprintf('The namespace alias "%s" is not known to any manager.', $alias));
    }
}