<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\QuoteGraphQl\Model\Cart;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\BillingAddressManagementInterface;
use Magento\Quote\Model\Quote\Address as QuoteAddress;

/**
 * Set billing address for a specified shopping cart
 */
class AssignBillingAddressToCart
{
    /**
     * @var BillingAddressManagementInterface
     */
    private $billingAddressManagement;

    /**
     * @param BillingAddressManagementInterface $billingAddressManagement
     */
    public function __construct(
        BillingAddressManagementInterface $billingAddressManagement
    ) {
        $this->billingAddressManagement = $billingAddressManagement;
    }

    /**
     * Assign billing address to cart
     *
     * @param CartInterface $cart
     * @param QuoteAddress $billingAddress
     * @param bool $useForShipping
     * @throws GraphQlInputException
     * @throws GraphQlNoSuchEntityException
     */
    public function execute(
        CartInterface $cart,
        QuoteAddress $billingAddress,
        bool $useForShipping
    ): void {
        try {
            $this->billingAddressManagement->assign($cart->getId(), $billingAddress, $useForShipping);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()));
        } catch (LocalizedException $e) {
            throw new GraphQlInputException(__($e->getMessage()));
        }
    }
}