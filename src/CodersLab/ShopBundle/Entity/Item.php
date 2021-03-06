<?php

namespace CodersLab\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use CodersLab\ShopBundle\Entity\Basket;
use CodersLab\ShopBundle\Entity\User;
use CodersLab\ShopBundle\Entity\Photo;

/**
 * Item
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Item {

    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="item")
     */
    private $photos;

    public function __construct() {
        $this->photos = new ArrayCollection();
        $this->baskets = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Item
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Item
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Item
     */
    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Add photos
     *
     * @param \CodersLab\ShopBundle\Entity\Photo $photos
     * @return Item
     */
    public function addPhoto(\CodersLab\ShopBundle\Entity\Photo $photos) {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \CodersLab\ShopBundle\Entity\Photo $photos
     */
    public function removePhoto(\CodersLab\ShopBundle\Entity\Photo $photos) {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos() {
        return $this->photos;
    }

    /**
     * Add baskets
     *
     * @param \CodersLab\ShopBundle\Entity\Basket $baskets
     * @return Item
     */
    public function addBasket(\CodersLab\ShopBundle\Entity\Basket $baskets) {
        $this->baskets[] = $baskets;

        return $this;
    }

    /**
     * Remove baskets
     *
     * @param \CodersLab\ShopBundle\Entity\Basket $baskets
     */
    public function removeBasket(\CodersLab\ShopBundle\Entity\Basket $baskets) {
        $this->baskets->removeElement($baskets);
    }

    /**
     * Get baskets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBaskets() {
        return $this->baskets;
    }

}
