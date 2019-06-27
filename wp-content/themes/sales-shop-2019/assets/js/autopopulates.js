jQuery(document).ready(function($) {
    /**
     * Get country options
     *
     */
    $( '#acf-field_5d1334a256be3' ).change(function () {

        var selected_city = $(this).val(); // Get selected value

        $( '#acf-field_5d1334b756be4' ).attr( 'disabled', 'disabled' );

        // If default is not selected get areas for selected country
        if( selected_city !== null && selected_city.length > 0 ) {
            // Send AJAX request
            data = {
                action: 'neighborhood_of_cities',
                pa_nonce: pa_vars.pa_nonce,
                city: selected_city,
            };

            // Get response and populate area select field
            $.post( ajaxurl, data, function(response) {
                $( '#acf-field_5d1334b756be4' ).html('');

                if( response ){
                    // Add neighborhoods to select field options
                    $.each(response, function(val, text) {
                        $( '#acf-field_5d1334b756be4' ).append( $('<option'+(pa_vars.current_neighborhood == text ? ' selected' : '')+'></option>').val(text).html(text) );
                    });

                    // Enable 'Select Area' field
                    $( '#acf-field_5d1334b756be4' ).removeAttr( 'disabled' );
                }
            });
        }
    }).change();
});