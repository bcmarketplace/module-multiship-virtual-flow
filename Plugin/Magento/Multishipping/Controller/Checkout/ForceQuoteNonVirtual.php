<?php
/**
 * Copyright © Baako Consulting LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace BCMarketplace\MultiShipVirtualFlow\Plugin\Magento\Multishipping\Controller\Checkout;

use BCMarketplace\MultiShipVirtualFlow\Helper\Data;
use Magento\Framework\App\RequestInterface;
use Magento\Multishipping\Controller\Checkout;
use Psr\Log\LoggerInterface;

/**
 * Plugin to bypass virtual quote check in multishipping checkout dispatch
 *
 * The goal with this plugin is to bypass the check at the very end of the
 * Checkout#dispatch method which redirects back to the cart if the entire quote
 * is virtual. The quote should otherwise act normally, which is why the flag
 * to force the quote to pretend it's non-virtual is unset just before the
 * action's execute method.
 */
class ForceQuoteNonVirtual
{
    /**
     * @param Data $helper
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly Data $helper,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * Around dispatch to temporarily force quote as non-virtual
     *
     * @param Checkout $subject
     * @param callable $proceed
     * @param RequestInterface $request
     * @return mixed
     */
    public function aroundDispatch(Checkout $subject, callable $proceed, RequestInterface $request)
    {
        $this->helper->setIsForceQuoteNonVirtual(true);

        try {
            $result = $proceed($request);
        } finally {
            $this->helper->setIsForceQuoteNonVirtual(false);
        }

        return $result;
    }

    /**
     * Before execute to reset the flag
     *
     * @param Checkout $subject
     * @return void
     */
    public function beforeExecute(Checkout $subject): void
    {
        $this->helper->setIsForceQuoteNonVirtual(false);
    }
}
