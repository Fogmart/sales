jQuery(function () {
    $(document).on('click', '.var-add-btn', optionAddToCart);

    function optionAddToCart() {
        var vProdEl = $('input[type="radio"][name="options"]:checked');
        var product_id = $('#productId').val();

        var data = {
            action: 'add_and_render_bar',
            product_id: product_id,
            _wpnonce: pData.nonce
        }
        
        if (vProdEl.length > 0) {
            data.variation_id = vProdEl.val();
        }

        $.post(woocommerce_params.ajax_url, data, function (reponse) {
            if (reponse.success) {
                var anchor = $('#product-added-anchor');
                anchor.empty();
                //Bar with product under header
                var addBar = $(reponse.data.added_bar);
                anchor.append(addBar);
                autoEmptyIn(anchor, 7000);

                //Update cart in header
                $('#header_cart').empty().append(reponse.data.header_cart);
            }
        });
    }

    function autoEmptyIn(container, time) {
        window.addBarEmptyTimer = setTimeout(function () {
            $(container).empty();
        }, time);
    }

    window.removeAddBar = function () {
        clearTimeout(window.addBarEmptyTimer);
        var anchor = $('#product-added-anchor');
        anchor.empty();
    }
});