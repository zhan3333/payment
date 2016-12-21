<?php
namespace Payment\Common\Chinapay\Data;
use Payment\Common\PayException;
use Payment\Utils\ArrayUtil;

/**
 * Created by PhpStorm.
 * User: helei  <dayugog@gmail.com>
 * Date: 2016/12/20
 * Time: 19:48
 *
 * @property string $order_no 商户网站唯一订单号
 * @property number $trans_date  订单日期，8位长  20160808
 * @property string $memo  查询时，给出的备注信息，可以进行一些日子记录
 *
 */
class QueryData extends ChinapayBaseData
{

    protected function buildData()
    {
        $this->retData = [
            'mch_id'     => $this->mchId,// 商户号码
            'trans_date' => $this->trans_date, // 订单交易时间
            'order_no'   => $this->order_no,
            'trans_type' => '0001',// 交易类型，0001 表示支付交易，0002 表示退款交易
        ];

        $this->retData = ArrayUtil::paraFilter($this->retData);
    }

    /**
     * 父类中，会进行数据检查，检查是否合法。如果不合法不会继续执行
     */
    protected function checkDataParam()
    {
        parent::checkDataParam();

        $transDate = $this->trans_date;
        $orderNo = $this->order_no;

        // 二者不能为空
        if (empty($transDate) && empty($orderNo)) {
            throw new PayException('必须提供订单号，以及订单交易的日期，格式：20160808');
        }
    }
}