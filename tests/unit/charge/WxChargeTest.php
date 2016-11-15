<?php
namespace charge;


use Codeception\Specify;

class WxChargeTest extends \Codeception\Test\Unit
{
    use Specify;
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var array
     */
    protected $wxConfig = [];

    protected function _before()
    {
        // 微信配置文件
        $this->wxConfig = require_once __DIR__ . '/../../../examples/wxconfig.php';
    }

    protected function _after()
    {
    }

    // tests
    public function testAppCharge()
    {
        $this->markTestIncomplete('尚未完成 微信 app 支付测试 unit');
    }

    public function testPubCharge()
    {
        $this->markTestIncomplete('尚未完成 微信 公众号 支付测试 unit');
    }

    public function testQRCharge()
    {
        $this->markTestIncomplete('尚未完成 微信 扫码 支付测试 unit');
    }
}