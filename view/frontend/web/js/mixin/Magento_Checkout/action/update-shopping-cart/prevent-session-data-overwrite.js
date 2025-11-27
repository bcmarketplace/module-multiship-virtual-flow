define([
    'Magento_Customer/js/customer-data',
    'mage/utils/wrapper'
], function (CustomerData, wrapper) {
    // This mixin prevents a situation during the addresses step of
    // multishipping checkout where the /multishipping/checkout/checkItems route
    // is requested just before the form data for the page is submitted, causing
    // a customer data section reload in parallel with the form submission
    // request, which can cause any data set in the session by the form
    // submission request to be erased if the customer data section load request
    // completes before it.
    return function (Widget) {
        Widget.prototype.validateItems = wrapper.wrapSuper(Widget.prototype.validateItems, function () {
            CustomerData.startReloadBuffer();

            return this._super.apply(this, arguments);
        });

        Widget.prototype.onError = wrapper.wrapSuper(function (response) {
            if (response['error_message']) {
                CustomerData.stopReloadBuffer();
                CustomerData.reloadBufferedSectionNames();
            }

            return this._super.apply(this, arguments);
        });

        Widget.prototype.submitForm = wrapper.wrapSuper(Widget.prototype.submitForm, function () {
            return this._super.apply(this, arguments);
        });

        return Widget;
    }
})