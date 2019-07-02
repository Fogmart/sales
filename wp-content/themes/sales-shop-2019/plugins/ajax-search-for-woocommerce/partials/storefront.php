<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('storefront_product_search')) {
    function storefront_product_search()
    {
        if (storefront_is_woocommerce_activated()) { ?>
            <div class="site-search">
                <?php echo do_shortcode('[wcas-search-form]'); ?>
            </div>
            <?php
        }
    }
}

add_action('wp_footer', 'dgwt_wcas_storefront_inverse_orientation', 100);

function dgwt_wcas_storefront_inverse_orientation()
{
    if (DGWT_WCAS()->settings->get_opt('enable_mobile_overlay') === 'on') {

        ?>
        <script>
            (function ($) {
                $(window).on('load', function () {
                    var $searchHandheld = $('.storefront-handheld-footer-bar .search a');

                    $(document).on('click', '.storefront-handheld-footer-bar .search > a', function (e) {
                        $(this).parent().removeClass('active');
                        $(this).parent().find('.dgwt-wcas-search-input').trigger('focus.autocomplete');
                        e.preventDefault();
                    });
                });
            }(jQuery));
        </script>
        <?php
    }
}