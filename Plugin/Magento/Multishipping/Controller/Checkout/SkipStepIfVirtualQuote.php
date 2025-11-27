<?php
/**
 * Copyright © Baako Consulting LLC. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace BCMarketplace\MultiShipVirtualFlow\Plugin\Magento\Multishipping\Controller\Checkout;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Multishipping\Model\Checkout\Type\Multishipping\State;

/**
 * Plugin to skip shipping/address steps for virtual quotes
 */
class SkipStepIfVirtualQuote
{
    /**
     * @param RedirectFactory $redirectResultFactory
     * @param State $checkoutState
     * @param string $skipRedirectPath
     */
    public function __construct(
        private readonly RedirectFactory $redirectResultFactory,
        private readonly State $checkoutState,
        private readonly string $skipRedirectPath = '*/checkout/billing'
    ) {
    }

    /**
     * Around execute to skip step if quote is virtual
     *
     * @param Action $subject
     * @param callable $proceed
     * @return mixed
     */
    public function aroundExecute(Action $subject, callable $proceed)
    {
        $quote = $this->checkoutState->getCheckout()->getQuote();
        if (!$quote->isVirtual()) {
            return $proceed();
        }

        $this->checkoutState->setCompleteStep(State::STEP_SELECT_ADDRESSES);
        $this->checkoutState->setCompleteStep(State::STEP_SHIPPING);

        $redirect = $this->redirectResultFactory->create();
        $redirect->setPath($this->skipRedirectPath);
        return $redirect;
    }
}
