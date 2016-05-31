<?php

namespace CodersLab\ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use CodersLab\ShopBundle\Entity\User;
use CodersLab\ShopBundle\Entity\Item;

/**
 * Basket
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Basket {

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="basket_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Product_in_basket", inversedBy="baskets")
     * 
     */
    private $productInBasket;

    /**
     * 
     */
    private $items;

    public function __construct() {
        $this->items = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_id", type="integer")
     */
    private $itemId;

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
     * Set status
     *
     * @param integer $status
     * @return Basket
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set customer
     *
     * @param integer $customer
     * @return Basket
     */
    public function setUser($customer) {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return integer 
     */
    public function getUser() {
        return $this->customer;
    }

    /**
     * Set itemId
     *
     * @param integer $itemId
     * @return Basket
     */
    public function setItemId($itemId) {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer 
     */
    public function getItemId() {
        return $this->itemId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Basket
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

    /**
     * Add items
     *
     * @param \CodersLab\ShopBundle\Entity\Item $items
     * @return Basket
     */
    public function addItem(\CodersLab\ShopBundle\Entity\Item $items) {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \CodersLab\ShopBundle\Entity\Item $items
     */
    public function removeItem(\CodersLab\ShopBundle\Entity\Item $items) {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems() {
        return $this->items;
    }

}
