<?php

namespace CodersLab\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use CodersLab\ShopBundle\Entity\Basket;
use CodersLab\ShopBundle\Entity\Customer;
use CodersLab\ShopBundle\Entity\Item;


/**
 * Photo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Photo
{
    /**
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="photos")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    
    
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
     * @ORM\Column(name="file_path", type="string", length=255)
     */
    private $filePath;

    /**
     * @var integer
     *
     * @ORM\Column(name="item_id", type="integer")
     */
    private $itemId;


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
     * Set filePath
     *
     * @param string $filePath
     * @return Photo
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Get filePath
     *
     * @return string 
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set itemId
     *
     * @param integer $itemId
     * @return Photo
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer 
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set item
     *
     * @param \CodersLab\ShopBundle\Entity\Item $item
     * @return Photo
     */
    public function setItem(\CodersLab\ShopBundle\Entity\Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \CodersLab\ShopBundle\Entity\Item 
     */
    public function getItem()
    {
        return $this->item;
    }
}
