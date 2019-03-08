<?php

require_once __DIR__ . '/vendor/autoload.php';
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

require_once __DIR__ . '/src/doctrine.php';

$entityManager = getEntityManager();

$order = new \SON\Entity\Order();
$order->setCustomer('Elvis Reis');

$invoice = new \SON\Entity\Invoice();
$invoice->setKey('854478557872588552699')
    ->setNumber(1)
    ->setSeries(1)
    ->setDate(new \DateTime())
    ->setXml('<?xml version="1.0" encoding="UTF-8"?>');

$order->setInvoice($invoice);
$entityManager->persist($order);
$entityManager->flush();

