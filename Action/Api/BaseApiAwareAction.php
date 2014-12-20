<?php
namespace Payum\Klarna\Checkout\Action\Api;

use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Klarna\Checkout\Config;

abstract class BaseApiAwareAction implements ActionInterface, ApiAwareInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var \Klarna_Checkout_ConnectorInterface
     */
    private $connector;

    public function __construct(\Klarna_Checkout_ConnectorInterface $connector = null)
    {
        $this->connector = $connector;
    }

    /**
     * {@inheritDoc}
     */
    public function setApi($api)
    {
        if (false == $api instanceof Config) {
            throw new UnsupportedApiException('Not supported. Expected Payum\Klarna\Checkout\Config instance to be set as api.');
        }

        $this->config = $api;
    }

    /**
     * @return \Klarna_Checkout_ConnectorInterface
     */
    protected function getConnector()
    {
        if ($this->connector) {
            return $this->connector;
        }

        \Klarna_Checkout_Order::$contentType = $this->config->contentType;
        \Klarna_Checkout_Order::$baseUri = $this->config->baseUri;

        return \Klarna_Checkout_Connector::create($this->config->secret);
    }

    /**
     * @param \ArrayAccess $details
     */
    protected function addMerchantId(\ArrayAccess $details)
    {
        if (false == isset($details['merchant'])) {
            $details['merchant'] = array();
        }

        $merchant = $details['merchant'];
        if (false == isset($merchant['id'])) {
            $merchant['id'] = (string) $this->config->merchantId;
        }

        $details['merchant'] = $merchant;
    }
}
