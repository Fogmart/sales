// Author: dendrofen
// Date: 24.06.2019

jQuery(function ($) {
    $(document).ready(function () {
        wcsCurrencySwitcher.init();
    });


    var wcsCurrencySwitcher = {
        init: function () {
            this.currSelector = '.wcs-curr';
            this.containerSelector = '.wcs-container';

            if (this.canProcess()) {
                this.eventHandlers();
            }
        },
        canProcess: function () {
            var changeCurrencyElems = $(this.currSelector);
            var containerElems = $(this.containerSelector);

            return changeCurrencyElems.length > 0 || containerElems.length > 0;
        },
        eventHandlers: function () {
            //event for select
            $('.wcs-container').on('change', function () {
                wcsCurrencySwitcher.valueElsHandler($(this));
            });
            //events for another
            $('.wcs-curr').on('click', function () {
                wcsCurrencySwitcher.dataElsHandler($(this));
            });
        },
        valueElsHandler: function ($this) {
            var newCurrency = $this.val();

            this.changeCurrency(newCurrency);
        },
        dataElsHandler: function ($this) {
            var newCurrency = $this.data('curr');

            this.changeCurrency(newCurrency);
        },
        changeCurrency: function (newCurrency) {
            if (newCurrency) {
                let data = {
                    newCurrency,
                };

                let params = {
                    data,
                    _ajax_nonce: wcsData.wcs_cc,
                    action: 'wcs_change',
                }
                $.post(woocommerce_params.ajax_url, params, function (data) {
                    var res = data.data;
                    if (data.success) {
                        wcsCurrencySwitcher.currencyChanged(res);
                    }
                });
            }
        },
        currencyChanged: function(res){
            document.location.reload(true);
        },
    };
});