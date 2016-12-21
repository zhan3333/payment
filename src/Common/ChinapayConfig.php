<?php
/**
 * Created by PhpStorm.
 * User: helei  <dayugog@gmail.com>
 * Date: 2016/12/20
 * Time: 16:47
 */

namespace Payment\Common;

use Payment\Utils\ArrayUtil;

/**
 * 银联在线配置文件
 * Class ChinapayConfig
 * @package Payment\Common
 */
final class ChinapayConfig extends ConfigInterface
{
    // 银联支付的网关
    public $getewayUrl = 'https://payment.chinapay.com/';

    //公钥文件
    public $publicKeyPath = '';

    //私钥文件，在CHINAPAY申请商户号时获取
    public $privateKeyPath = '';

    // 商户号，长度15位
    public $mchId;

    // 是否是调试模式
    public $debug = false;

    // 支付请求地址  线上
    public static $paymentUrl = 'https://payment.chinapay.com/CTITS/payment/TransGet';

    // 查询url  线上
    public static $queryUrl = 'https://payment.chinapay.com/CTITS/QueryWeb/processQuery.jsp';

    // 申请退款url  线上
    public static $refundUrl = 'https://payment.chinapay.com/CTITS/refund/SingleRefund.jsp';

    // 加密秘钥
    const DES_KEY = 'SCUBEPGW';

    const HASH_PAD = '0001ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff003021300906052b0e03021a05000414';

    public function __construct(array $config)
    {
        // 初始化配置信息
        try {
            $this->initConfig($config);
        } catch (PayException $e) {
            throw $e;
        }

        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Chinapay' . DIRECTORY_SEPARATOR;
        $this->publicKeyPath = "{$basePath}china_pay_public.key";

        if ($this->debug) {// 开发模式 使用测试地址
            self::$paymentUrl = 'http://payment-test.chinapay.com/pay/TransGet';
            self::$queryUrl = 'http://payment-test.chinapay.com/QueryWeb/processQuery.jsp';
            self::$refundUrl = 'http://payment-test.chinapay.com/refund1/SingleRefund.jsp';
        }
    }

    /**
     * 初始化银联的配置文件
     * @param array $config
     * @throws PayException
     */
    private function initConfig(array $config)
    {
        $config = ArrayUtil::paraFilter($config);

        // 初始开发模式 true  false
        if (key_exists('debug', $config) && is_bool($config['debug'])) {
            $this->debug = $config['debug'];
        } else {
            throw new PayException('请指定银联在线的使用模式，必须为bool值');
        }

        // 私钥路径
        if (key_exists('private_key', $config) && file_exists($config['private_key'])) {
            $this->privateKeyPath = $config['private_key'];
        } else {
            throw new PayException('必须指定秘钥文件路径');
        }

        // 商户号  16位长
        if (key_exists('mer_id', $config) && strlen($config['mer_id']) == '15') {
            $this->mchId = $config['mer_id'];
        } else {
            throw new PayException('必须提供银联在线分配的商户号');
        }
    }
}