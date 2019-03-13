<?php
/**
 * Created by PhpStorm.
 * User: Elvis
 * Date: 13/03/2019
 * Time: 12:54
 */

namespace SON\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ProductRepository")
 * @ORM\Table(name="produtos")
 */
class Product
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_produto", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="products")
     * @ORM\JoinTable(name="departamentos",
     *      joinColumns={@ORM\JoinColumn(name="fk_produto", referencedColumnName="id_produto")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="fk_categoria", referencedColumnName="id_categoria")}
     *      )
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

}