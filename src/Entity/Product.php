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
 * @ORM\Entity
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_produto", nullable=false, unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="products")
     * @@ORM\JoinTable(name="departaments")
     * @ORM\JoinColumn(name="id_produto", referencedColumnName="product_id")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

}