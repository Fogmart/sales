// Author: dendrofen
// Date: 11.07.2019

jQuery(function ($) {
    $(document).ready(function () {
        $('.table__cell.with-order-btn').find('.btn-order').hide();
        $('.table__cell.with-order-btn').find('.b-price').addClass('b-price-fake').removeClass('b-price');
        $('.mp-dele-row').show();
        $('.mp-dele-col').show();

        $(document).on('dblclick', '.mp-table-container .table__cell', function () {
            var $this = $(this);
            var isEditNow = $(this).attr('contentEditable');
            $this.toggleClass('bg-warning');
            if (isEditNow) {
                $(this).removeAttr('contentEditable');
                $this.find('.table-icon').css('border', 'none');
            } else {
                $(this).attr('contentEditable', true);
                $this.find('.table-icon').css('border', '1px solid red');
            }
        });

        $(document).on('click', '.mp-add-col', function () {
            var root = $(this).closest('.mp-table-item');
            var prices = root.find('.mp-prices');
            var newCol = prices.find('.table__group-col').last().clone();
            prices.append(newCol);
            alertify.success('Колонка добавлена');
        });

        $(document).on('click', '.mp-get-sh', function(){
            var root = $(this).closest('.mp-table-item');
            var name = root.find('input[name="name"]').val();
            alert('[model_price_table table="'+name+'"]');
        });

        $(document).on('click', '.mp-add-row', function () {
            var root = $(this).closest('.mp-table-item');
            var items = root.find('.mp-items');
            var prices = root.find('.mp-prices');
            var newRow = items.find('.table__row').last().clone();
            items.append(newRow); //new row in items column

            prices.find('.table__group-col').each(function () {
                var $this = $(this);
                var newRow = $this.find('.table__row').last().clone();
                $this.find('.table__group-col-inside').append(newRow);
            });

            alertify.success('Строка добавлена');
        });

        $(document).on('click', '.mp-dele-col', function () {
            if($('.mp-prices').find('.table__group-col').length > 1){
                $(this).closest('.table__group-col').remove();
                alertify.success('Колонка удалена');
            }else{
                alertify.error('невозможно удалить последнюю колонку');
            }
        });

        $(document).on('click', '.mp-dele-row', function () {
            var root = $(this).closest('.mp-table-item');
            var $this = $(this).closest('.table__row');
            var rmIndex = 0;
            root.find('.mp-items').find('.table__row').each(function (index) {
                if ($(this).get(0) == $this.get(0)) {
                    rmIndex = index;
                }
            });
            if (root.find('.mp-items').find('.table__row').length > 2) {
                $this.remove();


                var prices = root.find('.mp-prices');
                prices.find('.table__group-col').each(function () {
                    var $this = $(this);
                    var newRow = $this.find('.table__row').each(function (index) {
                        if (index == rmIndex) {
                            $(this).remove();
                        }
                    });
                });

                alertify.success('Строка удалена');
            }else{
                alertify.error('Невозможно удалить последнюю строку');
            }
        });

        $('.mp-delete').click(function () {
            var root = $(this).closest('.mp-table-item');
            var name = root.find('input[name="name"]').val();
            var data = {
                name,
            };
            var params = {
                data,
                _ajax_nonce: mpData.mp_cs,
                action: 'mp_settings_del',
            };

            $.post(ajaxurl, params, function (data) {
                var res = data.data;
                if (data.success) {
                    alertify.success(res.message);
                    window.location.reload();
                } else {
                    alertify.error(res.message);
                }
            });
        });
        $('.mp-save').click(function () {
            var root = $(this).closest('.mp-table-item');

            var code = root.find('.mp-table-code').clone();
            code.find('.table__cell.with-order-btn').find('.b-price-fake').addClass('b-price').removeClass('b-price-fake');
            code.find('.table__cell.with-order-btn').find('.btn-order').show();

            // code.find('.b-price .current-price').removeAttr('contentEditable');
            // code.find('.b-price .current-price').removeClass('bg-warning');

            // code.find('.b-price .old-price').removeAttr('contentEditable');
            // code.find('.b-price .old-price').removeClass('bg-warning');

            // code.find('.b-price .new-price').removeAttr('contentEditable');
            // code.find('.b-price .new-price').removeClass('bg-warning');

            code.find('.table__cell').removeAttr('contentEditable');
            code.find('.table__cell').removeClass('bg-warning');
            code.find('.table-icon').css('border', 'none');
            code.find('.mp-dele-row').hide();
            code.find('.mp-dele-col').hide();

            var code = code.html();
            var name = root.find('input[name="name"]').val();

            var data = {
                code,
                name,
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