<?php

namespace addons\epay\library;

use think\Config;
use Exception;
use think\Hook;
use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;

/**
 * 订单服务类
 *
 * @package addons\epay\library
 */
class Service
{

    /**
     * 创建支付对象
     * @param string $type 支付类型
     * @param array $config 配置信息
     * @return bool|\Yansongda\Pay\Gateways\Alipay|\Yansongda\Pay\Gateways\Wechat
     */
    public static function createPay($type, $config = [])
    {
        $type = strtolower($type);
        if (!in_array($type, ['wechat', 'alipay'])) {
            return false;
        }
        $pay = Pay::$type(array_merge(self::getConfig($type), $config));
        return $pay;
    }

    /**
     * 验证回调是否成功
     * @param string $type 支付类型
     * @param array $config 配置信息
     * @return bool|\Yansongda\Pay\Gateways\Alipay|\Yansongda\Pay\Gateways\Wechat
     */
    public static function checkNotify($type, $config = [])
    {
        $type = strtolower($type);
        if (!in_array($type, ['wechat', 'alipay'])) {
            return false;
        }
        try {
            $pay = Pay::$type(array_merge(self::getConfig($type), $config));
            $data = $pay->verify();
            Log::debug($type . ' notify', $data->all());

            if ($type == 'alipay') {
                if (in_array($data->trade_status, ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
                    return $pay;
                }
            } else {
                return $pay;
            }
        } catch (Exception $e) {
            return false;
        }

        return $pay;
    }

    /**
     * 验证返回是否成功
     * @param string $type 支付类型
     * @param array $config 配置信息
     * @return bool|\Yansongda\Pay\Gateways\Alipay|\Yansongda\Pay\Gateways\Wechat
     */
    public static function checkReturn($type, $config = [])
    {
        $type = strtolower($type);
        if (!in_array($type, ['wechat', 'alipay'])) {
            return false;
        }
        try {
            $pay = Pay::$type(array_merge(self::getConfig($type), $config))->verify();
        } catch (Exception $e) {
            return false;
        }

        return $pay;
    }

    /**
     * 获取配置
     * @param string $type 支付类型
     * @return array|mixed
     */
    public static function getConfig($type = 'wechat')
    {
        $config = Config::get('payment.' . $type);
        if (!$config) {
            return [];
        }
        $config['notify_url'] = !empty($config['notify_url']) ? addon_url('epay/api/notify', [], false) . '/type/' . $type : $config['notify_url'];
        $config['return_url'] = !empty($config['notify_url']) ? addon_url('epay/api/returnx', [], false) . '/type/' . $type : $config['return_url'];
        $config['notify_url'] = !preg_match("/^(http:\/\/|https:\/\/)/i", $config['notify_url']) ? request()->root(true) . $config['notify_url'] : $config['notify_url'];
        return $config;
    }

}