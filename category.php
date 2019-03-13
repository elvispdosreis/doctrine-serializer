<?php

require_once __DIR__ . '/vendor/autoload.php';
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

require_once __DIR__ . '/src/doctrine.php';

$entityManager = getEntityManager();


$entity = $entityManager->getReference(\SON\Entity\Category::class, 1);

$category = new \SON\Entity\Category();
$category->setName('Componentes para PC');
$category->setParent($entity);

$arr = explode('>', 'Informática > Componentes para PC > Fontes de Alimentação > ATX > 500W a 590W');
foreach ($arr as $key => $value) {
    // $category = new \SON\Entity\Category();
    // $category->setName(trim($value));
    // $category->setChildren($category);
}

$entityManager->persist($category);
$entityManager->flush();

