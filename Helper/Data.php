<?php
/**
 * Copyright © Baako Consulting LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace BCMarketplace\MultiShipVirtualFlow\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Helper for managing virtual quote state during multishipping checkout
 */
class Data extends AbstractHelper
{
    /**
     * @var bool
     */
    private bool $isForceQuoteNonVirtual = false;

    /**
     * Get flag indicating if quote should be forced to non-virtual
     *
     * @return bool
     */
    public function getIsForceQuoteNonVirtual(): bool
    {
        return $this->isForceQuoteNonVirtual;
    }

    /**
     * Set flag to force quote to be treated as non-virtual
     *
     * @param bool $flag
     * @return $this
     */
    public function setIsForceQuoteNonVirtual(bool $flag): self
    {
        $this->isForceQuoteNonVirtual = $flag;
        return $this;
    }
}
