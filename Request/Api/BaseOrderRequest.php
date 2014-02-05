<?php
namespace Payum\Klarna\Checkout\Request\Api;

use Payum\Core\Exception\InvalidArgumentException;
use Payum\Core\Request\BaseModelRequest;

abstract class BaseOrderRequest extends BaseModelRequest
{
    /**
     * @var \Klarna_Checkout_Order
     */
    protected $order;

    public function __construct($model)
    {
        if (false == (is_array($model) || $model instanceof \ArrayAccess)) {
            throw new InvalidArgumentException('Given model is invalid. Should be an array or ArrayAccess instance.');
        }

        parent::__construct($model);
    }

    /**
     * @return \Klarna_Checkout_Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param \Klarna_Checkout_Order $order
     */
    public function setOrder(\Klarna_Checkout_Order $order)
    {
        $this->order = $order;
    }
}