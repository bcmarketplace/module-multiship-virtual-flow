<?php
/**
 * Copyright © Baako Consulting LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace BCMarketplace\MultiShipVirtualFlow\Plugin\Magento\Multishipping\Model\Checkout\Type\Multishipping;

use Magento\Multishipping\Model\Checkout\Type\Multishipping;
use Psr\Log\LoggerInterface;

/**
 * Plugin to remove shipping addresses for virtual quotes before order creation
 */
class RemoveShippingAddressesIfVirtualQuote
{
    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Before create orders to clean up shipping addresses for virtual quotes
     *
     * @param Multishipping $subject
     * @return void
     */
    public function beforeCreateOrders(Multishipping $subject): void
    {
        $quote = $subject->getQuote();
        if (!$quote->isVirtual()) {
            return;
        }

        $shippingAddresses = $quote->getAllShippingAddresses();
        if (empty($shippingAddresses)) {
            return;
        }

        foreach ($shippingAddresses as $shippingAddress) {
            $quote->removeAddress($shippingAddress->getId());
        }

        $this->logger->debug(
            sprintf(
                'MultiShipVirtualFlow: Removed %d shipping addresses from virtual quote %d',
                count($shippingAddresses),
                $quote->getId()
            )
        );
    }
}
