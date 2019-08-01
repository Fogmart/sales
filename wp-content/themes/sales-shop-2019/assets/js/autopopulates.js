jQuery(document).ready(function($) {
    var city_id;
    var neighborhood_id;
    if ($('select').is('#acf-field_5d1334a256be3')) {
        city_id = '#acf-field_5d1334a256be3';
        neighborhood_id = '#acf-field_5d1334b756be4';
    } else if ($('select').is('#acf-field_5d2ebe8c852ff')) {
        city_id = '#acf-field_5d2ebe8c852ff';
        neighborhood_id = '#acf-field_5d2ec34a19148';
    } else {
        city_id = false;
    }

    /**
     * Get country options
     *
     */
    if (city_id !== false) {
        $( city_id ).change(function () {

            var selected_city = $(this).val(); // Get selected value

            if (pa_vars.is_admin) {
                $( neighborhood_id ).attr( 'disabled', 'disabled' );
            }

            // If default is not selected get areas for selected country
            if( selected_city !== null && selected_city.length > 0 ) {
                // Send AJAX request
                data = {
                    action: 'neighborhood_of_cities',
                    pa_nonce: pa_vars.pa_nonce,
                    city: selected_city,
                };

                // Get response and populate area select field
                $.post( pa_vars.ajaxurl, data, function(response) {
                    $( neighborhood_id ).html('');

                    if( response ){
                        // Add neighborhoods to select field options
                        $.each(response, function(val, text) {
                            $( neighborhood_id ).append( $('<option'+(pa_vars.current_neighborhood == text ? ' selected' : '')+'></option>').val(text).html(text) );
                        });

                        if (pa_vars.is_admin) {
                            // Enable 'Select Area' field
                            $( neighborhood_id ).removeAttr( 'disabled' );
                        } else {
                            $( neighborhood_id ).selectric();
                        }
                    }
                });
            }
        }).change();
    }

});