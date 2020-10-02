<?php

/*
 * Copyright(c) 2020 Shadow Enterprise, Inc. All rights reserved.
 * http://www.shadow-ep.co.jp/
 */

namespace Plugin\SeShareButton4\Form\Type\Admin;

use Plugin\SeShareButton4\Entity\ShareButtonConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ConfigType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if ( !isset($options['button_list']) || !is_array($options['button_list']) || empty($options['button_list']) ) {
            return false;
        }

        foreach ( $options['button_list'] as $key => $value ) {

            # 有効化ボタン
            $builder
                ->add($key .'_enabled', CheckboxType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => trans('se_share_button.common.label.enabled'),
                    'data' => ( isset($options['db_data'][$key]['enabled']) ) ? boolval($options['db_data'][$key]['enabled']) : boolval($value['enabled']),
                ]);

            # 共有URL
            if ( $key == 'email' ) {    // メールの場合だけURLではないのでイレギュラー処理
                $builder                
                    ->add($key .'_url', TextType::class, [
                        'mapped' => false,
                        'required' => true,
                        'label' => trans('se_share_button.common.label.url'),
                        'data' => ( isset($options['db_data'][$key]['url']) ) ? $options['db_data'][$key]['url'] : $value['url'] ,
                        'attr' => [
                            'placeholder' => trans('se_share_button.common.placeholder.url'),
                            'readonly' => true, 
                        ],
                        'constraints' => [
                            new NotBlank(),
                        ],
                    ]);
            } else {
                $builder
                    ->add($key .'_url', TextType::class, [
                        'mapped' => false,
                        'required' => true,
                        'label' => trans('se_share_button.common.label.url'),
                        'data' => ( isset($options['db_data'][$key]['url']) ) ? $options['db_data'][$key]['url'] : $value['url'] ,
                        'attr' => [
                            'placeholder' => trans('se_share_button.common.placeholder.url')
                        ],
                        'constraints' => [
                            new NotBlank(),
                            new Url(),
                        ],
                    ]);
            }


            $builder
                # サムネイル
                ->add($key .'_img', FileType::class, [
                    'mapped' => false,
                    'required' => false,
                    //'doc_path' => 'nurseryDocumentsPath',
                    //'doc_name' => 'docUrl',
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/gif',
                                'image/png',
                                'image/jpg',
                                'image/jpeg',
                                'application/gif',
                                'application/png',
                                'application/jpeg',
                            ],
                            'mimeTypesMessage' => trans('se_share_button.common.message.possible_filetype', [ '%type%' => $options['mime_types']] ),
                        ])
                    ],
                    'attr' => [
                        'class' => 'img-thumbnail',
                        'data-attr' => ( isset($options['db_data'][$key]['img']) ) ? $options['db_data'][$key]['img'] : $value['img'],
                    ],
                    //'data_class' => null,
                ])

                # サムネイル削除
                ->add($key .'_img_del', CheckboxType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => trans('se_share_button.common.label.usedefault'),
                ]);


        }

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => ShareButtonConfig::class,
            'db_data' => [],
            'button_list' => [],
            'mime_types' => ''
        ]);
    }
}
