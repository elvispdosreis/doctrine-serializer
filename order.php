<?php

require_once __DIR__ . '/vendor/autoload.php';
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

require_once __DIR__ . '/src/doctrine.php';

$entityManager = getEntityManager();
$serializer = JMS\Serializer\SerializerBuilder::create()->build();
$group = \JMS\Serializer\SerializationContext::create()->setGroups(['details']);
$group->setSerializeNull(true);

// Detalhes da venda.
$order = $entityManager->getRepository(\SON\Entity\Order::class)->find(1);

$jsonContent = $serializer->serialize($order, 'json', $group);
print_r($jsonContent);

$arr = json_decode($jsonContent);

/*
 * A venda pode retornar ou não como uma nfe, no trecho abaixo eu pegaria o json que eu receberia
 * de um post onde o cliente pode editar, editar um json ou preencher uma nova nfe
 * {"series":1,"key":"854478557872588552699","number":1,"date":"2019-03-08","xml":"<?xml version=\"1.0\" encoding=\"UTF-8\"?>"}
 */

$invoice = $serializer->deserialize(json_encode($arr->invoice), \SON\Entity\Invoice::class, 'json');


/*
 * Nesse ponto eu preciso persistir o $invoice no banco de dados, nesse momento o objeto acima não é gerenciavel, e não
 * sei se ele é uma inclusão ou alteração.
 * o que eu poderia e pequisar pela $order que eu conheço o id dela e mandar gravar o $invoice,
 * ou pesquisar na $invoice pelo $id da $order, e se existir mesclar com o dados da deserialização.
 */


print_r($invoice);


