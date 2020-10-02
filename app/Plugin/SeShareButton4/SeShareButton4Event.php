<?php

/*
 * Copyright(c) 2020 Shadow Enterprise, Inc. All rights reserved.
 * http://www.shadow-ep.co.jp/
 */

namespace Plugin\SeShareButton4;

use Eccube\Common\EccubeConfig;
use Eccube\Event\TemplateEvent;
use Plugin\SeShareButton4\Repository\ShareButtonConfigRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SeShareButton4Event implements EventSubscriberInterface
{

    protected $eccubeConfig;
    protected $shareButtonConfigRepository;

    /**
     * コンストラクタ
     */
    public function __construct(
        EccubeConfig $eccubeConfig,
        ShareButtonConfigRepository $shareButtonConfigRepository
    ) {
        $this->eccubeConfig = $eccubeConfig;
        $this->shareButtonConfigRepository = $shareButtonConfigRepository;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Product/detail.twig' => 'onDefaultProductDetailTwig',
        ];
    }

    /**
     * フロント -> 商品詳細
     */
    public function onDefaultProductDetailTwig(TemplateEvent $event)
    {
        $ShareButtonConfig = $this->shareButtonConfigRepository->get();

        // 基本となるサイズをここで調整する
        $decodeInfo = $ShareButtonConfig->getConfigJson();

        // 画像が存在すればサイズを配列に追加する(デフォルトは20x20とする) - cssで処理させるので今後必要なら利用する
/*
        if ( $decodeInfo ) {
            $permitExt = $this->eccubeConfig['Se_ShareButton_img_valid_extention'];
            $permitExt = explode(',', str_replace('.', '', $permitExt));
            $permitExt = array_flip($permitExt);

            // get plugin dir
            $pluginDir = $this->eccubeConfig['eccube_html_plugin_dir'];
            foreach ( $decodeInfo as $key => $value ) {
                if ( isset($value['img']) && !empty($value['img']) ) {
                    $imageFile = $pluginDir .'/SeShareButton4/assets/img/' .$value['img'];
                    if ( file_exists($imageFile) ) {
                        $extention = substr($imageFile, strrpos($imageFile, '.') + 1);
                        if ( $extention == 'svg' ) {
                            $decodeInfo[$key]['w'] = $decodeInfo[$key]['h'] = 20;
                        } else 
                        if ( isset($permitExt[strtolower($extention)]) ) {
                            $imageSizes = getimagesize($imageFile);
                            if ( isset($imageSizes[0]) && isset($imageSizes[1]) ) {
                                // 高さは20px固定とする？
                                $decodeInfo[$key]['h'] = 20;
                                $decodeInfo[$key]['w'] = round( ( 20 / (int)$imageSizes[1] ) * (int)$imageSizes[0], 2 );
                            }
                        }
                    }
                }
            }
        }
*/

        // JSで利用するので配列ではなくJSON型で渡す
        $event->setParameter( 'ShareButtonConfig', json_encode($decodeInfo) );

        $event->addSnippet('@SeShareButton4/product_detail.twig');
    }

}
