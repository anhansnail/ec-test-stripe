<?php

/*
 * Copyright(c) 2020 Shadow Enterprise, Inc. All rights reserved.
 * http://www.shadow-ep.co.jp/
 */

namespace Plugin\SeShareButton4\Util;

/**
 * 汎用関数クラス
 */
class CommonUtil
{
    /**
     * プラグインコード定数
     */
    const PLUGIN_CODE = "SeShareButton4";

    public static function &getInstance()
    {
        static $CommonUtil;

        if (empty($CommonUtil)) {
            $CommonUtil = new CommonUtil();
        }

        return $CommonUtil;
    }

    /**
     * ログ出力（エラー）
     *
     * @param mixed $msg
     * @param array $masks 配列キーを指定してマスク
     */
    public static function logError($msg, $masks = ["Pass", "Token"])
    {
        $text = $msg;
        if (is_array($msg)) {
            $text = print_r(CommonUtil::arrayMaskValue($msg, $masks), true);
        } elseif (is_object($msg)) {
            $text = get_class($msg);
        }
        logs(CommonUtil::PLUGIN_CODE)->error($text);
    }

    /**
     * ログ出力（情報）
     *
     * @param mixed $msg
     * @param array $masks 配列キーを指定してマスク
     */
    public static function logInfo($msg, $masks = ["Pass", "Token"])
    {
        $text = $msg;
        if (is_array($msg)) {
            $text = print_r(CommonUtil::arrayMaskValue($msg, $masks), true);
        } elseif (is_object($msg)) {
            $text = get_class($msg);
        }
        logs(CommonUtil::PLUGIN_CODE)->info($text);
    }

    /**
     * ログ出力（デバッグ）
     *
     * @param mixed $msg
     * @param array $masks 配列キーを指定してマスク
     */
    public static function logDebug($msg, $masks = ["Pass", "Token"])
    {
        $text = $msg;
        if (is_array($msg)) {
            $text = print_r(CommonUtil::arrayMaskValue($msg, $masks), true);
        } elseif (is_object($msg)) {
            $text = get_class($msg);
        }
        logs(CommonUtil::PLUGIN_CODE)->debug($text);
    }

    public static function convCVSText($txt)
    {
        return mb_convert_kana($txt, 'KASV', 'UTF-8');
    }

    public static function convTdTenantName($shop_name)
    {
        if (empty($shop_name)) return '';
        $shop_name = mb_convert_encoding($shop_name, "EUC-JP", "UTF-8");
        $enc_name = base64_encode($shop_name);
        if (strlen($enc_name) <= 25) {
            return $enc_name;
        }
        return '';
    }

    /**
     * 日付をISO8601形式にフォーマットする
     *
     * @param string $date
     * @return string ISO8601 format date
     **/
    function formatISO8601($date)
    {
        $n = sscanf($date, '%4s%2s%2s%2s%2s%2s',
                    $year, $month, $day, $hour, $min, $sec);
        return sprintf('%s-%s-%s %s:%s:%s',
                       $year, $month, $day, $hour, $min, $sec);
    }

}
