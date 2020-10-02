<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Eccube\Repository\CustomerRepository;


class TopController extends AbstractController
{

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @Route("/", name="homepage")
     * @Template("index.twig")
     */
    public function index()
    {
        $current_user = $this->getUser();

        $customer = $this->customerRepository->find($current_user->getId());
$customer->setCustomerStripeId('asdas');
$this->entityManager->persist($customer);
$this->entityManager->persist($customer);
        dump($customer);
        exit();
        return [];
    }
}
