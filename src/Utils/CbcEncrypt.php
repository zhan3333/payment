<?php
/**
 * Created by PhpStorm.
 * User: helei  <dayugog@gmail.com>
 * Date: 2016/12/21
 * Time: 9:31
 */

namespace Payment\Utils;


class CbcEncrypt
{
    protected $key;

    // cbc资源句柄
    private $td;

    public function __construct($key)
    {
        $this->key = $key;

        //$this->td = mcrypt_module_open();
    }

    /**
     * 设置key
     * @param $key
     * @author helei
     */
    public function setKey($key)
    {
        $this->key = $key;
    }
}