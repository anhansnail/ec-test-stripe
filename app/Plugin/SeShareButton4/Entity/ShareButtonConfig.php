<?php

/*
 * Copyright(c) 2020 Shadow Enterprise, Inc. All rights reserved.
 * http://www.shadow-ep.co.jp/
 */

namespace Plugin\SeShareButton4\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShareButtonConfig
 *
 * @ORM\Table(name="plg_se_share_button_config")
 * @ORM\Entity(repositoryClass="Plugin\SeShareButton4\Repository\ShareButtonConfigRepository")
 */
class ShareButtonConfig
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var json
     *
     * @ORM\Column(name="config_json", type="json")
     */
    private $config_json;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getConfigJson()
    {
        return json_decode($this->config_json, true);
    }

    /**
     * @param array $config_json
     *
     * @return $this;
     */
    public function setConfigJson(array $config_json)
    {
        $this->config_json = ( !empty($config_json) ) ? json_encode($config_json) : null ;

        return $this;
    }

}
