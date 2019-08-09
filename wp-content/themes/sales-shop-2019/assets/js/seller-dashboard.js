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
});