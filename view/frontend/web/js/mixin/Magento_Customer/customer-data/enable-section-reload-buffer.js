define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    return function (CustomerData) {
        CustomerData._reloadBufferStartCount = 0;
        CustomerData._reloadBufferLoadPromise = null;
        CustomerData._reloadBufferSectionNames = null;

        CustomerData.reload = wrapper.wrapSuper(CustomerData.reload, function (sectionNames, forceNewSectionTimestamp) {
            if (!CustomerData.isReloadBufferActive()) {
                return this._super.apply(this, arguments);
            }


            CustomerData.invalidate(sectionNames);

            sectionNames.forEach(function (sectionName) {
                CustomerData._reloadBufferSectionNames.add(sectionName);
            });

            return CustomerData._reloadBufferLoadPromise;
        });

        $.extend(CustomerData, {
            initReloadBuffer: function () {
                CustomerData.flushReloadBuffer();

                CustomerData._reloadBufferStartCount = 0;
                CustomerData._reloadBufferSectionNames = new Set();
                CustomerData._reloadBufferLoadPromise = $.Deferred();
            },

            startReloadBuffer: function () {
                if (CustomerData._reloadBufferStartCount === 0) {
                    CustomerData.initReloadBuffer();
                }
                ++CustomerData._reloadBufferStartCount;

                return CustomerData._reloadBufferStartCount === 1;
            },

            stopReloadBuffer: function () {
                --CustomerData._reloadBufferStartCount;
                
                return !CustomerData.isReloadBufferActive();
            },

            isReloadBufferActive: function () {
                return CustomerData._reloadBufferStartCount > 0;
            },

            getReloadBufferSectionNames: function () {
                if (!CustomerData._reloadBufferSectionNames) {
                    return [];
                }


                var sectionNames = [];
                for (var sectionName of CustomerData._reloadBufferSectionNames) {
                    sectionNames.push(sectionName);
                }
                return sectionNames;
            },

            flushReloadBuffer: function () {            
                var sectionNames = CustomerData.getReloadBufferSectionNames();

                bufferedSections = new Set();

                return sectionNames;
            },

            reloadBufferedSectionNames: function (forceNewSectionTimestamp) {
                if (CustomerData.isReloadBufferActive()) {
                    return loadPromise;
                }


                var sectionNames = CustomerData.flushReloadBuffer();
                
                CustomerData.invalidate(sectionNames);
                
                return CustomerData.reload(sectionNames, forceNewSectionTimestamp)
                    .done(CustomerData._reloadBufferLoadPromise.resolve.bind(CustomerData._reloadBufferLoadPromise))
                    .fail(CustomerData._reloadBufferLoadPromise.reject.bind(CustomerData._reloadBufferLoadPromise));
            }
        });

        return CustomerData;
    }
})