jQuery(function () {
    function redeemCoupon() {
        var $this = $(this);

        var orderId = $this.data('order');
        var orderItemId = $this.data('item');

        var data = {
            action: 'ss_redeem_coupon',
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