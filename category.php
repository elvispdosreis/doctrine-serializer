<?php

require_once __DIR__ . '/vendor/autoload.php';
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

require_once __DIR__ . '/src/doctrine.php';

$entityManager = getEntityManager();


$entity = $entityManager->getReference(\SON\Entity\Category::class, 1);
//https://wiki.php.net/rfc/iterable
$category = new \SON\Entity\Category();
$children->setName('Informática');
$category->setParent($entity);

$arr = explode('>', 'Informática > Componentes para PC > Fontes de Alimentação > ATX > 500W a 590W');
foreach ($arr as $key => $value) {
     $parent = $entityManager->getRepository(\SON\Entity\Category::class)->findOneBy(['name' => trim($value)]);
     $children = new \SON\Entity\Category();
     $children->setName(trim($value));
     $entity->setChildren($children);
}

$entityManager->persist($children);
$entityManager->flush();

