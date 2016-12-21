<?php
/**
 * Created by PhpStorm.
 * User: helei  <dayugog@gmail.com>
 * Date: 2016/12/20
 * Time: 19:46
 */

namespace Payment\Query;


use Payment\Common\BaseData;
use Payment\Common\Chinapay\ChinapayBaseStrategy;
use Payment\Common\Chinapay\Data\QueryData;

/**
 * 银联在线  交易查询，  包括：支付 退款
 * Class ChinapayQuery
 * @package Payment\Query
 */
class ChinapayQuery extends ChinapayBaseStrategy
{

    protected function getBuildDataClass()
    {
        return QueryData::class;
    }
}