<?php
/**
 * Created by PhpStorm.
 * User: helei  <dayugog@gmail.com>
 * Date: 2016/12/20
 * Time: 19:48
 */

namespace Payment\Common\Chinapay\Data;


use Payment\Common\BaseData;
use Payment\Common\ChinapayConfig;
use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;

/**
 * 银联在线   数据基类
 * Class ChinapayBaseData
 * @package Payment\Common\Chinapay\Data
 *
 * @property string $getewayUrl 银联在线支付的网关
 * @property string $publicKeyPath 公钥路径
 * @property string $privateKeyPath 私钥路径
 * @property string $mchId  商户号，  15位 长
 *
 */
abstract class ChinapayBaseData extends BaseData
{
    public $privateKey = [];

    /**
     * AliBaseData constructor.
     * @param ChinapayConfig $config
     * @param array $reqData
     * @throws PayException
     */
    public function __construct(ChinapayConfig $config, array $reqData)
    {
        parent::__construct($config, $reqData);
    }

    /**
     * 银联在线的签名，真是格外一股清流  TMD
     *
     * 设置签名
     */
    public function setSign()
    {
        $this->buildData();

        $values = ArrayUtil::removeKeys($this->retData, ['sign', 'sign_type']);

        $signStr = '';
        foreach ($this->retData as $key => $value) {
            $signStr .= $value;
        }

        $this->retData['sign'] = $this->makeSign($signStr);
    }

    /**
     * 签名数据
     * @param string $signStr
     * @return string
     */
    protected function makeSign($signStr)
    {
        // TODO: Implement makeSign() method.
    }

    /**
     * 银联在线 初始化相关配置  返回merid，或者pgid
     * @param string $path
     *
     * @return bool|string
     */
    protected function buildKey($path)
    {
        !empty($this->privateKey) && $this->privateKey = [];

        $keyFile = parse_ini_file($path);
        if (! $keyFile) {
            return false;
        }

        $id = $hex = "";
        if (key_exists("MERID", $keyFile)) {
            $id = $keyFile["MERID"];
            $this->privateKey["MERID"] = $id;
            $hex = substr($keyFile["prikeyS"], 80);
        } elseif (key_exists("PGID", $keyFile)) {
            $id = $keyFile["PGID"];
            $this->privateKey["PGID"] = $id;
            $hex = substr($keyFile["pubkeyS"], 48);
        }else {
            return false;
        }

        $bin = hex2bin($hex);
        echo $bin;exit;
    }

    /**
     * 首选在父类中检查私钥是否正确
     */
    protected function checkDataParam()
    {
        // 初始化私钥问题  成功会返回一个
        $mchId = $this->buildKey($this->privateKeyPath);
        if ($mchId != $this->mchId) {
            throw new PayException('请检查 ' . $this->privateKeyPath . ' 私钥文件内容。可能被纂改！');
        }
    }

}