<?php

namespace CodersLab\ShopBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

   
    
    /**
     * @ORM\OneToOne(targetEntity="Basket")
     * @ORM\JoinColumn(name="basket_id", referencedColumnName="id")
     */
    private $basket;
    
    /**
     * @ORM\OneToMany(targetEntity="Basket", mappedBy="user")
     */
    private $orders;

    public function __construct() {
        parent::__construct();
        $this->baskets = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=100, nullable=true)
     */
    private $surname;
    


    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=100, nullable=true)
     */
    private $mail;

    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Customer
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Customer
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add baskets
     *
     * @param \CodersLab\ShopBundle\Entity\Basket $baskets
     * @return Customer
     */
    public function addBasket(\CodersLab\ShopBundle\Entity\Basket $baskets)
    {
        $this->baskets[] = $baskets;

        return $this;
    }

    /**
     * Remove baskets
     *
     * @param \CodersLab\ShopBundle\Entity\Basket $baskets
     */
    public function removeBasket(\CodersLab\ShopBundle\Entity\Basket $baskets)
    {
        $this->baskets->removeElement($baskets);
    }

    /**
     * Get baskets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBaskets()
    {
        return $this->baskets;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Customer
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    


    /**
     * Set basket
     *
     * @param \CodersLab\ShopBundle\Entity\Basket $basket
     * @return User
     */
    public function setBasket(\CodersLab\ShopBundle\Entity\Basket $basket = null)
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * Get basket
     *
     * @return \CodersLab\ShopBundle\Entity\Basket 
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * Add orders
     *
     * @param \CodersLab\ShopBundle\Entity\Basket $orders
     * @return User
     */
    public function addOrder(\CodersLab\ShopBundle\Entity\Basket $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \CodersLab\ShopBundle\Entity\Basket $orders
     */
    public function removeOrder(\CodersLab\ShopBundle\Entity\Basket $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
