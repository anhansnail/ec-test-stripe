<?php

/*
 * Copyright(c) 2020 Shadow Enterprise, Inc. All rights reserved.
 * http://www.shadow-ep.co.jp/
 */

namespace Plugin\SeShareButton4\Repository;

use Eccube\Repository\AbstractRepository;
use Plugin\SeShareButton4\Entity\ShareButtonConfig;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * ShareButtonConfigRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShareButtonConfigRepository extends AbstractRepository
{
    /**
     * ShareButtonConfigRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShareButtonConfig::class);
    }

    /**
     * @param int $id
     * @return null|ShareButtonConfig
     */
    public function get($id = 1)
    {
        return $this->find($id);
    }
}