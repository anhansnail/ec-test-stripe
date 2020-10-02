<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;
use Eccube\Entity\Product;

/**
  * @EntityExtension("Eccube\Entity\Product")
 */
trait ProductTrait
{
    /**
     * @ORM\Column(type="decimal")
     */
    public  $price = 1;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public  $product_stripe_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public  $price_stripe_id;

    /**
     * Set price.
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set product_stripe_id.
     *
     * @param int $product_stripe_id
     *
     * @return Product
     */
    public function setProductStripe($product_stripe_id)
    {
        $this->product_stripe_id = $product_stripe_id;

        return $this;
    }

    /**
     * Get product_stripe_id.
     *
     * @return int
     */
    public function getProductStripe()
    {
        return $this->product_stripe_id;
    }

    /**
     * Set price_stripe_id.
     *
     * @param int $price_stripe_id
     *
     * @return Product
     */
    public function setPriceStripe($price_stripe_id)
    {
        $this->price_stripe_id = $price_stripe_id;

        return $this;
    }

    /**
     * Get price_strip.
     *
     * @return int
     */
    public function getPriceStripe()
    {
        return $this->price_stripe_id;
    }
}
