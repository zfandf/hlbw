<?php

namespace app\api\controller;

use addons\epay\library\Service;
use app\common\controller\Api;
use app\common\model\ObjectOrder;

/**
 * 支付接口
 */
class Pay extends Api
{

    protected $noNeedLogin = [];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 支付
     * @param String $type 支付类型。alipay-支付宝支付，否则是微信支付
     * @param String $order_id 订单号
     * @param string $platform 请求来源，默认“app”
     * @param string $openid 微信公众号或者小程序支付时，必须要传openid。
     * @return
     */
    public function pay_order()
    {
        $type = $this->request->request('type');
        if (!$type) {
            $this->error('支付类型错误');
        }
        $order_id = $this->request->request('order_id');
        $user = $this->auth->getUser();
        $info = ObjectOrder::get(['id' => $order_id, 'user_id' => $user->id]);
        if (!$info) {
            $this->error('订单号不正确');
        }
        $out_trade_no = $info->order_no;
        $amount = $info->price;
        $method = $this->request->request('platform');

        //这里配置两个回调地址,一个回调URL，一个支付完成返回URL，如果不配置则以payment.php中的为准
        $notifyurl = $this->request->root(true) . '/addons/epay/index/nofityit/type/' . $type;
        $returnurl = $this->request->root(true) . '/addons/epay/index/returnit/type/' . $type;

        $config = [
            'notify_url' => $notifyurl,
            'return_url' => $returnurl
        ];

        //创建支付对象
        $pay = Service::createPay($type, $config);

        if ($type == 'alipay') {
            //支付宝支付,请根据你的需求,仅选择你所需要的即可
            $order = [
                'out_trade_no' => $out_trade_no,//你的订单号
                'total_amount' => $amount,//单位元
                'subject' => '华力必维服务订单',
            ];

            switch ($method) {
                case 'web':
                    //电脑支付,跳转
                    return $pay->web($order)->send();
                case 'wap':
                    //手机网页支付,跳转
                    return $pay->wap($order)->send();
                case 'app':
                    //APP支付,直接返回字符串
                    $pay->app($order)->send();
                case 'scan':
                    //扫码支付,直接返回字符串
                    return $pay->scan($order);
                case 'pos':
                    //刷卡支付,直接返回字符串
                    //刷卡支付必须要有auth_code
                    $order['auth_code'] = '289756915257123456';
                    return $pay->pos($order);
                default:
                    //其它支付类型请参考：https://yansongda.gitbooks.io/pay/docs/alipay/pay.html
            }
        } else if ($type == 'wechat') {
            //微信支付,请根据你的需求,仅选择你所需要的即可
            $openid = $this->request->request('openid');
            if (in_array($method, ['mp', 'miniapps']) && !$openid) {
                $this->error("参数openid不能为空");
            }
            $order = [
                'out_trade_no' => $out_trade_no,//你的订单号
                'body' => '华力必维服务订单',
                'total_fee' => $amount * 100, //单位分
                'openid' => $openid
            ];

            switch ($method) {
                case 'mp':
                    //公众号支付
                    //公众号支付必须有openid
                    $order['openid'] = $openid;
                    return $pay->mp($order);
                case 'wap':
                    //手机网页支付,跳转
                    $this->success('',$pay->wap($order)->send());
                case 'app':
                    //APP支付,直接返回字符串
                    return $pay->app($order)->send();
                case 'scan':
                    //扫码支付,直接返回字符串
                    return $pay->scan($order);
                case 'pos':
                    //刷卡支付,直接返回字符串
                    //刷卡支付必须要有auth_code
                    $order['auth_code'] = '289756915257123456';
                    return $pay->pos($order);
                case 'miniapp':
                    //小程序支付,直接返回字符串
                    //小程序支付必须要有openid
                    $order['openid'] = $openid;
                    return $pay->miniapp($order);
                default:
                    //其它支付类型请参考：https://yansongda.gitbooks.io/pay/docs/wechat/pay.html
            }
        }
        $this->error("未找到支付类型[{$type}][{$method}]");
    }

    /**
     * 通知回调(仅供开发测试体验)
     */
    public function notifyit()
    {
        $type = $this->request->param('type');
        $pay = Service::checkNotify($type);
        if (!$pay) {
            echo '签名错误';
            return;
        }

        //你可以直接通过$pay->verify();获取到相关信息
        //支付宝可以获取到out_trade_no,total_amount等信息
        //微信可以获取到out_trade_no,total_fee等信息
        $data = $pay->verify();

        //下面这句必须要执行,且在此之前不能有任何输出
        echo $pay->success();

        return;
    }

    /**
     * 支付成功的返回(仅供开发测试体验)
     */
    public function returnit()
    {
        $type = $this->request->param('type');
        $pay = Service::checkReturn($type);
        if (!$pay) {
            $this->error('签名错误');
        }
        //你可以在这里定义你的提示信息,但切记不可在此编写逻辑
        $this->success("恭喜你！支付成功!", addon_url("epay/index/index"));

        return;
    }


}
