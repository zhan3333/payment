<?php
/**
 * 银联在线 配置文件
 * User: helei  <dayugog@gmail.com>
 * Date: 2016/12/20
 * Time: 17:15
 */

return [
    'private_key'       => dirname(__FILE__) . DIRECTORY_SEPARATOR . 'china_pay_private.key',
    'mer_id'            => 'xxxxxxxxxxxx',// 商户id  15位长
    'debug'             => false,// 银联在线支持 调试模式，  boolean
];