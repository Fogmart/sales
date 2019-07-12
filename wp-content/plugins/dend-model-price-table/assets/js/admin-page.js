// Author: dendrofen
// Date: 11.07.2019

jQuery(function ($) {
    $(document).ready(function () {
        $('.table__cell.with-order-btn').find('.btn-order').hide();
        $('.table__cell.with-order-btn').find('.b-price').addClass('b-price-fake').removeClass('b-price');

        $(document).on('dblclick', '.b-price-fake .current-price', function(){
            var $this = $(this);
            var isEditNow = $(this).attr('contentEditable');
            $this.toggleClass('bg-warning');
            if(isEditNow){
                $(this).removeAttr('contentEditable');
            }else{
                $(this).attr('contentEditable', true);
            }
        });

        $('.mp-save').click(function(){
            var root = $('.mp-table-settings');
            var code = root.find('.source').clone();
            code.find('.table__cell.with-order-btn').find('.b-price-fake').addClass('b-price').removeClass('b-price-fake');
            code.find('.table__cell.with-order-btn').find('.btn-order').show();
            code.find('.b-price .current-price').removeAttr('contentEditable');
            code.find('.b-price .current-price').removeClass('bg-warning');

            var code = code.html();
            
            var data = {
                code,
            };
        
            var params = {
                data,
                _ajax_nonce: mpData.mp_cs,
                action: 'mp_settings',
            };
        
            $.post(ajaxurl, params, function (data) {
                var res = data.data;
                if (data.success) {
                    alertify.success(res.message);
                } else {
                    alertify.error(res.message);
                }
            });

        });
    });
});