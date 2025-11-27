<?php
/**
 * Copyright © Baako Consulting LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace BCMarketplace\MultiShipVirtualFlow\Plugin\Magento\Multishipping\Helper\Data;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Multishipping\Helper\Data;
use Magento\Store\Model\ScopeInterface;

/**
 * Plugin to remove virtual quote restriction from multishipping availability check
 */
class RemoveVirtualQuoteCheckoutAvailableCheck
{
    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Around method to allow multishipping for virtual quotes
     *
     * @param Data $subject
     * @param callable $proceed
     * @return bool
     */
    public function aroundIsMultishippingCheckoutAvailable(Data $subject, callable $proceed): bool
    {
        $quote = $subject->getQuote();
        $isMultishipping = $this->scopeConfig->isSetFlag(
            Data::XML_PATH_CHECKOUT_MULTIPLE_AVAILABLE,
            ScopeInterface::SCOPE_STORE
        );
        
        if (!$quote || !$quote->hasItems()) {
            return $isMultishipping;
        }
        
        return $isMultishipping
            && !$quote->hasItemsWithDecimalQty()
            && $quote->validateMinimumAmount(true)
            && $quote->getItemsSummaryQty() <= $subject->getMaximumQty();
    }
}
