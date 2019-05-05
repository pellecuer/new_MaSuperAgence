<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch {

    
    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10, max=400)
     */
    private $minSurface;

    
    /**
     * Undocumented variable
     *
     * @var ArrayCollection
     */
    private $options;


    public function __construct()
    {
        $this->options = new ArrayCollection();
    }


    /**
     * Get the value of maxPrice
     *
     * @return  int|null
     */ 
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set the value of maxPrice
     *
     * @param  int|null  $maxPrice
     *
     * @return  self
     */ 
    public function setMaxPrice(int $maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get the value of minSurface
     *
     * @return  int|null
     */ 
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * Set the value of minSurface
     *
     * @param  int|null  $minSurface
     *
     * @return  self
     */ 
    public function setMinSurface(int $minSurface)
    {
        $this->minSurface = $minSurface;

        return $this;
    }


    /**
     * Get undocumented variable
     *
     * @return  ArrayCollection
     */ 
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set undocumented variable
     *
     * @param  ArrayCollection  $options  Undocumented variable
     *
     * @return  self
     */ 
    public function setOptions(ArrayCollection $options)
    {
        $this->options = $options;

        return $this;
    }
}