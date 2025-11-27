var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/update-shopping-cart': {
                'BCMarketplace_MultiShipVirtualFlow/js/mixin/Magento_Checkout/action/update-shopping-cart/prevent-session-data-overwrite': true
            },
            'Magento_Customer/js/customer-data': {
                'BCMarketplace_MultiShipVirtualFlow/js/mixin/Magento_Customer/customer-data/enable-section-reload-buffer': true
            }
        }
    }
}
