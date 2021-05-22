<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{

    /**
     * @var int| null
     *
     */
    private $maxPrice;
    /**
     * @var int| null
     * @Assert\Range(min=10 , max=400)
     */
    private $minSurface;
    

    /**
     * @var ArrayCollection
     */

     private $options;

     public function __construct()
     {
         $this->options=new ArrayCollection();
     }
    /**
     * Get null
     *
     * @return  int|
     */ 
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * Set null
     *
     * @param  int|  $minSurface  null
     *
     * @return  self
     */ 
    public function setMinSurface($minSurface)
    {
        $this->minSurface = $minSurface;

        return $this;
    }

    /**
     * Get null
     *
     * @return  int|
     */ 
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set null
     *
     * @param  int|  $maxPrice  null
     *
     * @return  self
     */ 
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

     /**
      * Get the value of options
      */ 
     public function getOptions()
     {
          return $this->options;
     }

     /**
      * Set the value of options
      *
      * @return  self
      */ 
     public function setOptions($options)
     {
          $this->options = $options;

          return $this;
     }
}
