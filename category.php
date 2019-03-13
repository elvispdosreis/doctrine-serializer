<?php

require_once __DIR__ . '/vendor/autoload.php';
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

require_once __DIR__ . '/src/doctrine.php';

$entityManager = getEntityManager();

$arr = explode('>', 'Informática > Componentes para PC > Fontes de Alimentação > ATX > 500W a 590W');
$arr = array_map('trim', $arr);
$arr = new \Doctrine\Common\Collections\ArrayCollection($arr);

$entity = $entityManager->getReference(\SON\Entity\Category::class, 1);
$category = new \SON\Entity\Category();
$category->setName('Informática');


$children = new \SON\Entity\Category();
$children->setName('Componentes para PC');
$category->setParent($category);

$entityManager->persist($category);
$entityManager->persist($children);
$entityManager->flush();
