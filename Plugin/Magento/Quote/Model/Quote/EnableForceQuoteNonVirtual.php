<?php
/**
 * Copyright © Baako Consulting LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace BCMarketplace\MultiShipVirtualFlow\Plugin\Magento\Quote\Model\Quote;

use BCMarketplace\MultiShipVirtualFlow\Helper\Data;
use Magento\Quote\Model\Quote;

/**
 * Plugin to force quote to be treated as non-virtual when flag is set
 */
class EnableForceQuoteNonVirtual
{
    /**
     * @param Data $helper
     */
    public function __construct(
        private readonly Data $helper
    ) {
    }

    /**
     * Around isVirtual to return false when flag is set
     *
     * @param Quote $quote
     * @param callable $proceed
     * @return bool
     */
    public function aroundIsVirtual(Quote $quote, callable $proceed): bool
    {
        if (!$this->helper->getIsForceQuoteNonVirtual()) {
            return $proceed();
        }

        return false;
    }
}
