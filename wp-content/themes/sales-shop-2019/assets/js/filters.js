jQuery(function ($) {
    function renderFilters(filterParams) {
        //rendering filters
        $.ajax({
            type: 'GET',
            url: woocommerce_params.ajax_url+"?action=render_filters&"+filterParams,
            success: function (data) {
                var htmlFilters = $(data.data);
                $('.filters-update').empty().append(htmlFilters);

                document.initRangeSlider();
            }
        });
    }

    function getFilterValue(filterEl, filterName) {
        var filterValue = "";
        var isSingle = filterEl.hasClass('filter__single');
        if (isSingle) {
            filterValue = filterEl.val();
        } else {
            var checked = $('*[data-filter="' + filterName + '"]:checked');

            filterValue = $.map(checked, function (item) {
                return encodeURI($(item).val());
            }).join(',');
        }
        return filterValue;
    }

    document.updateFilters = function(disableRendering = false) {
        var $this = $(this);

        var filterName = $this.data('filter');
        var filterValue = null;

        var search = window.location.search;
        if (document.filterParams === undefined) {
            document.filterParams = new URLSearchParams(search);
        }

        filterValue = getFilterValue($this, filterName);

        if (filterValue !== "") {
            document.filterParams.set(filterName, filterValue);
        } else {
            document.filterParams.delete(filterName);
        }
        if(!disableRendering){
            console.log(document.filterParams.toString());
            renderFilters(document.filterParams.toString());
        }
    }

    //only one city
    $(document).on('click', 'input[data-filter="city_id"]', function () {
        $('input[data-filter="city_id"]').not(this).prop('checked', false);
    });

    $(document).on('change', '.filter__var', function(){
        document.updateFilters();
    });
});