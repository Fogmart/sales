jQuery(function () {
    function redeemCoupon() {
        var $this = $(this);

        var orderId = $this.data('order');
        var orderItemId = $this.data('item');

        var data = {
            action: 'redeem_coupon',
            _wpnonce: sdData.redeemNonce,
            orderId,
            orderItemId
        };

        $.post(woocommerce_params.ajax_url, data)
            .done(function () {
                $this.addClass('processed');
                $this.attr('disabled', 'disabled');
            });
    }

    $(document).on('click', '.button-redeem', redeemCoupon);

    var dataPicker = $('input.datepicker-here').data('datepicker');
    dataPicker.update('onHide', function (inst) {
        var dpEl = inst.$el;
        var submitClass = 'submit-on-change';

        if(dpEl.hasClass(submitClass)){
            dpEl.removeClass(submitClass);

            var form = dpEl.parents('form');
            form.submit();
        }
    });
});