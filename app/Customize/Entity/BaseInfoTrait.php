<?php

namespace Customize\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eccube\Annotation\EntityExtension;
use Eccube\Entity\BaseInfo;

/**
  * @EntityExtension("Eccube\Entity\BaseInfo")
 */
trait BaseInfoTrait
{
    /**
     * @ORM\Column(name="facebook", type="string", nullable=true)
     */

    private  $facebook;

    /**
     * @ORM\Column(name="instagram", type="string", nullable=true)
     */

    private  $instagram;
    /**
     * @ORM\Column(name="linkedin", type="string", nullable=true)
     */

    private  $linkedin;

    /**
     * @ORM\Column(name="stripe_public_key", type="string", nullable=true)
     */
    private  $stripe_public_key;

    /**
     * @ORM\Column(name="stripe_secret_key", type="string", nullable=true)
     */
    private  $stripe_secret_key;

    /**
     * @ORM\Column(name="google_map_url", type="string", length=4000, nullable=true)
     */
    private  $google_map_url;

    /**
     * @ORM\Column(name="capcha", type="string", nullable=true)
     */
    private  $capcha;

    /**
     * Set facebook.
     *
     * @param string $facebook
     *
     * @return BaseInfo
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook.
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set instagram.
     *
     * @param string $instagram
     *
     * @return BaseInfo
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram.
     *
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set linkedin.
     *
     * @param string $linkedin
     *
     * @return BaseInfo
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin.
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set stripe_public_key.
     *
     * @param string $stripe_public_key
     *
     * @return BaseInfo
     */
    public function setStripePublicKey($stripe_public_key)
    {
        $this->stripe_public_key = $stripe_public_key;

        return $this;
    }

    /**
     * Get stripe_public_key.
     *
     * @return string
     */
    public function getStripePublicKey()
    {
        return $this->stripe_public_key;
    }

    /**
     * Set stripe_secret_key.
     *
     * @param string $stripe_secret_key
     *
     * @return BaseInfo
     */
    public function setStripeSecretKey($stripe_secret_key)
    {
        $this->stripe_secret_key = $stripe_secret_key;

        return $this;
    }

    /**
     * Get stripe_secret_key.
     *
     * @return string
     */
    public function getStripeSecretKey()
    {
        return $this->stripe_secret_key;
    }

    /**
     * Set google map.
     *
     * @param string $map
     *
     * @return BaseInfo
     */
    public function setGoogleMapUrl($map)
    {
        $this->google_map_url = $map;

        return $this;
    }

    /**
     * Get google map.
     *
     * @return string
     */
    public function getGoogleMapUrl()
    {
        return $this->google_map_url;
    }

    /**
     * Set capcha.
     *
     * @param string $capcha
     *
     * @return BaseInfo
     */
    public function setCapCha($capcha)
    {
        $this->capcha = $capcha;

        return $this;
    }

    /**
     * Get capcha.
     *
     * @return string
     */
    public function getCapCha()
    {
        return $this->capcha;
    }

}
