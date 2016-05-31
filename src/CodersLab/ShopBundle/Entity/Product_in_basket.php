<?php

namespace CodersLab\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product_in_basket
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Product_in_basket {

    /**
     * @ORM\ManyToOne(targetEntity="Basket", inversedBy="product_in_basket")
     * @ORM\JoinColumn(name="basket_id", referencedColumnName="id")
     */
    private $basket;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\OneToMany(targetEntity="Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     * @ORM\Column(name="item", type="string", length=255)
     */
    private $item;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set item
     *
     * @param string $item
     * @return Product_in_basket
     */
    public function setItem($item) {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return string 
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Product_in_basket
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity() {
        return $this->quantity;
    }

}
