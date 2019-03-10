<?php

require_once __DIR__ . '/vendor/autoload.php';
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

require_once __DIR__ . '/src/doctrine.php';

$em = getEntityManager();

$connection = \Doctrine\DBAL\DriverManager::getConnection($dbParams);






$group = \JMS\Serializer\SerializationContext::create()->setGroups(['details']);
$group->setSerializeNull(true);




$json = '{"id":3, "series":4,"key":"854478557872588552699","number":1,"date":"2019-03-08","xml":"<?xml version=\"1.0\" encoding=\"UTF-8\"?>"}';
$em = $registry->getManager();

$invoice = $serializer->deserialize($json, \SON\Entity\Invoice::class, 'json');
if($entityManager->getUnitOfWork()->getEntityState($invoice) === \Doctrine\ORM\UnitOfWork::STATE_NEW){
    $order = $entityManager->getRepository(\SON\Entity\Order::class)->find(3);
    $invoice->setOrder($order);
    $em->persist($invoice);
}

$em->flush();

var_dump($invoice);

