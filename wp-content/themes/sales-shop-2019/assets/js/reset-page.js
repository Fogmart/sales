jQuery(function($){
    $(document).on('submit', 'form', submitResetForm);

    function submitResetForm(){
        let form = $(this);

        $.post(woocommerce_params.ajax_url, form.serialize(), function(response){
            if(response.success){
                let currStep = getCurrentStep(form);
                let data = response.data;
                switch(currStep.data('step')){
                    case 'check': 
                    $('input[name="reset_key"]').val(data.token);
                    $('input[name="user_login"]').val(data.user_login);
                    break;
                }
                showNextResetStep(currStep);
            }
        });
        return false;
    }

    function getCurrentStep(formEl){
        return $(formEl).parents('.reset-step');
    }

    function showNextResetStep(stepEl){
        $(stepEl).hide().next('.reset-step').show();
    }
});