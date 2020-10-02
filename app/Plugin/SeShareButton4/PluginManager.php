<?php

/*
 * Copyright(c) 2020 Shadow Enterprise, Inc. All rights reserved.
 * http://www.shadow-ep.co.jp/
 */

namespace Plugin\SeShareButton4;

use Eccube\Plugin\AbstractPluginManager;
use Eccube\Common\EccubeConfig;
use Eccube\Entity\Layout;
use Eccube\Entity\Page;
use Eccube\Entity\PageLayout;
use Eccube\Entity\Payment;
use Plugin\SeShareButton4\Entity\ShareButtonConfig;
use Plugin\SeShareButton4\Util\CommonUtil;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PluginManager extends AbstractPluginManager
{
    /**
     * Update the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function update(array $meta, ContainerInterface $container)
    {
        CommonUtil::logInfo('PluginManager::update start.');

        try {
            // プラグイン設定用のレコードを生成
            $this->createConfig($container);
            $this->createPageLayout($container);
        } catch (\Exception $e) {
            CommonUtil::logError($e->getMessage());
            throw $e;
        }

        CommonUtil::logInfo('PluginManager::update end.');
    }

    /**
     * Enable the plugin.
     *
     * @param array $meta
     * @param ContainerInterface $container
     */
    public function enable(array $meta, ContainerInterface $container)
    {
        CommonUtil::logInfo('PluginManager::enable start.');

        try {
            // プラグイン設定用のレコードを生成
            $this->createConfig($container);
            $this->createPageLayout($container);
        } catch (\Exception $e) {
            CommonUtil::logError($e->getMessage());
            throw $e;
        }

        CommonUtil::logInfo('PluginManager::enable end.');
    }

    /**
     * プラグイン設定用のレコードを生成
     */
    private function createConfig(ContainerInterface $container)
    {
        CommonUtil::logInfo('PluginManager::createConfig start.');

        $entityManager = $container->get('doctrine')->getManager();
        $ShareButtonConfig = $entityManager->find(ShareButtonConfig::class, 1);

        // update の場合どうするか・・ToDo
        if ( $ShareButtonConfig ) {
            CommonUtil::logInfo('ShareButtonConfig found.');
            return;
        }

        $EccubeConfig = $container->get(EccubeConfig::class);

        $ShareButtonConfig = new ShareButtonConfig();
        $ShareButtonConfig->setConfigJson($EccubeConfig['Se_ShareButton_default_button_list']);

        $entityManager->persist($ShareButtonConfig);
        $entityManager->flush($ShareButtonConfig);

        CommonUtil::logInfo('PluginManager::createConfig end.');
    }

    /**
     * 商品詳細向けにページおよびページレイアウトを生成
     */
    private function createPageLayout(ContainerInterface $container)
    {
        CommonUtil::logInfo('PluginManager::createPageLayout start.');
        CommonUtil::logInfo('PluginManager::createPageLayout end.');
    }
}
