<?php

namespace PMNTS\Gateway\Gateway;

abstract class AbstractCommand implements \Magento\Payment\Gateway\CommandInterface
{
    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    protected $scopeConfig;

    /** @var \PMNTS\Gateway\Helper\Data */
    protected $pmntsHelper;

    /** @var \Pmnts\Gateway\Model\GatewayFactory */
    protected $gatewayFactory;

    /**
     * AbstractCommand constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \PMNTS\Gateway\Helper\Data $pmntsHelper
     * @param \Pmnts\Gateway\Model\GatewayFactory $gatewayFactory
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \PMNTS\Gateway\Helper\Data $pmntsHelper,
        \Pmnts\Gateway\Model\GatewayFactory $gatewayFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->pmntsHelper = $pmntsHelper;
        $this->gatewayFactory = $gatewayFactory;
    }

    /**
     * @param $storeId
     * @return \Pmnts\Gateway\Model\Gateway
     */
    public function getGateway($storeId)
    {
        $username = $this->scopeConfig->getValue('payment/pmnts_gateway/username', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
        $token = $this->scopeConfig->getValue('payment/pmnts_gateway/token', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
        $sandbox = (bool)$this->scopeConfig->getValue('payment/pmnts_gateway/sandbox_mode', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);

        return $this->gatewayFactory->create([
            'username' => $username,
            'token' => $token,
            'test_mode' => $sandbox
        ]);
    }
}