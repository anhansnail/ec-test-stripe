<?php

/*
 * Copyright(c) 2020 Shadow Enterprise, Inc. All rights reserved.
 * http://www.shadow-ep.co.jp/
 */

namespace Plugin\SeShareButton4\Controller\Admin;

use Eccube\Controller\AbstractController;
use Plugin\SeShareButton4\Form\Type\Admin\ConfigType;
use Plugin\SeShareButton4\Repository\ShareButtonConfigRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ConfigController extends AbstractController
{
    /**
     * @var ShareButtonConfigRepository
     */
    protected $shareButtonConfigRepository;

    /**
     * ShareButtonConfigController constructor.
     *
     * @param ShareButtonConfigRepository $shareButtonConfigRepository
     */
    public function __construct(
        ShareButtonConfigRepository $shareButtonConfigRepository
    ) {
        $this->shareButtonConfigRepository = $shareButtonConfigRepository;
    }

    /**
     * @Route("/%eccube_admin_route%/share_button/config", name="se_share_button4_admin_config")
     * @Template("@SeShareButton4/admin/config.twig")
     *   設定画面を利用する場合、[PluginCode]_admin_config の名前でページを作成する必要がある *スネークケース
     */
    public function index(Request $request)
    {
        $ShareButtonConfig = $this->shareButtonConfigRepository->get();
        $configButtnList = $this->eccubeConfig['Se_ShareButton_default_button_list'];
        $options = [
            'db_data' => $ShareButtonConfig->getConfigJson(),
            'button_list' => $configButtnList,
            'mime_types' => str_replace( ',', '/', $this->eccubeConfig['Se_ShareButton_img_valid_extention'] )
        ];
        $form = $this->createForm(ConfigType::class, null, $options);

        $form->handleRequest($request);

        // 保存処理
        if ($form->isSubmitted() && $form->isValid()) {
            // プラグイン設定を保存する
            //$ShareButtonConfig = $form->getData();

            // 全てのフォームデータを取得
            $formData  = $request->request->get($form->getName());
            $formParam = [];
            foreach ( $formData as $key => $value ) {
                $explode = explode('_', $key);
                if ( isset($explode[0]) && isset($configButtnList[$explode[0]]) ) {
                    $formParam[$explode[0]][substr($key, strlen($explode[0])+1)] = $value;
                }
            }

            // 画像はPOSTなのでここで確認
            $check = 'img';
            foreach ( $configButtnList as $key => $value ) {
                $uploadFile = $form->get($key .'_' .$check)->getData();
                if ( $uploadFile ) {
                    $originalFilename = pathinfo($uploadFile->getClientOriginalName(), PATHINFO_FILENAME);

                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $uploadFile->move(
                            $this->eccubeConfig['Se_ShareButton_img_upload_dir'],
                            $newFilename
                        );
                        // set newFilename
                        $formParam[$key][$check] = $newFilename;
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                        $message = trans('se_share_button.common.message.failed_upload');
                        $form->get($check)->addError( new FormError( $message, $message ) );
                    }
                }

            }

            // デフォルトと比較して値を埋める
            $nowData = $ShareButtonConfig->getConfigJson();
            $updateArray = $configButtnList;
            $countUpdateArray = ( !empty($updateArray) ) ? count( $updateArray ) : 0 ;
            $countEnabledNull = 0;
            foreach ( $updateArray as $key => $value ) {
                foreach ( $value as $vkey => $vvalue ) {
                    if ( ( $vkey == 'enabled' ) && !isset($formParam[$key][$vkey]) ) {
                        // 有効化がなければ0で埋める
                        $updateArray[$key][$vkey] = 0;
                        $countEnabledNull++;
                    } else
                    //if ( ( $vkey == 'img' ) && ( !isset($formParam[$key][$vkey]) || empty($formParam[$key][$vkey]) ) ) {
                    if ( $vkey == 'img' ) {
                        if ( isset($formParam[$key][$vkey.'_del']) && ( $formParam[$key][$vkey.'_del'] == 1 ) ) {
                            // デフォルトフラグがあるので初期値へ
                            continue;
                        } else
                        if ( isset($formParam[$key][$vkey]) && !empty($formParam[$key][$vkey]) ) {
                            // 新規登録画像が存在する
                            $updateArray[$key][$vkey] = $formParam[$key][$vkey];
                        } else
                        if ( isset($nowData[$key][$vkey]) && !empty($nowData[$key][$vkey]) ) {
                            // 登録済みからの変更なし
                            $updateArray[$key][$vkey] = $nowData[$key][$vkey];
                        } else {
                            // 不明な場合はデフォルトへ
                            continue;
                        }
                    } else
                    if ( isset($formParam[$key][$vkey]) ) {
                        $updateArray[$key][$vkey] = $formParam[$key][$vkey];
                    }
                }
            }

            if ( !empty($countUpdateArray) && !empty($countEnabledNull) && ( $countUpdateArray == $countEnabledNull ) ) {
                $this->addError('se_share_button.common.message.failed_enabled', 'admin');
            } else
            // エラーが無ければファイルチェック
            if ( ( count($form->getErrors(true)) < 1 ) && ( !isset($countEnabledError) || ( $countEnabledError != true ) ) ) {

                $ShareButtonConfig->setConfigJson($updateArray);
                $this->entityManager->persist($ShareButtonConfig);

                $this->entityManager->flush();

                $this->addSuccess
                    ('se_share_button.admin.save.success', 'admin');

                return $this->redirectToRoute('se_share_button4_admin_config');

            }
        }

        return [
            'form' => $form->createView(),
        ];
    }

}
