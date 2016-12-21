<?php
namespace Payment\Common\Chinapay;
use Payment\Common\BaseData;
use Payment\Common\BaseStrategy;
use Payment\Common\ChinapayConfig;
use Payment\Common\PayException;

/**
 * 银联在线支付
 * User: helei  <dayugog@gmail.com>
 * Date: 2016/12/20
 * Time: 19:30
 */
abstract class ChinapayBaseStrategy implements BaseStrategy
{

    /**
     * 银联在线的配置文件
     * @var ChinapayConfig $config
     */
    protected $config;

    /**
     * 支付数据
     * @var BaseData $reqData
     */
    protected $reqData;

    public function __construct(array $config)
    {
        /* 设置内部字符编码为 UTF-8 */
        mb_internal_encoding("UTF-8");

        try {
            $this->config = new ChinapayConfig($config);
        } catch (PayException $e) {
            throw $e;
        }
    }

    /**
     * 获取支付对应的数据完成类
     * @return BaseData
     * @author helei
     */
    abstract protected function getBuildDataClass();

    /**
     * 处理数据
     * @param array $data
     * @throws PayException
     * @return array|string
     */
    public function handle(array $data)
    {
        $buildClass = $this->getBuildDataClass();

        try {
            $this->reqData = new $buildClass($this->config, $data);
        } catch (PayException $e) {
            throw $e;
        }

        $this->reqData->setSign();

        $data = $this->reqData->getData();

        return $this->retData($data);
    }

    /**
     * 处理银联在线的返回值并返回给客户端
     * @param array $ret
     * @return mixed
     * @author helei
     */
    protected function retData(array $ret)
    {
        return $ret;
    }
}