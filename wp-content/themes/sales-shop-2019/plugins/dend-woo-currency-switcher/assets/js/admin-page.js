// Author: dendrofen
// Date: 24.06.2019

jQuery(function ($) {
    var settingsForm = {
        init: function () {
            this.formEl = $('.wcs-settings-form');

            if (this.canProcess) {
                this.initEventsHandler();
            }
        },
        canProcess: function () {
            return this.formEl.length > 0;
        },
        initEventsHandler: function () {
            $('.wcs-save').click(this.formSubmited);
        },
        formSubmited: function (e) {
            var form = settingsForm.formEl.get(0);
            
            if (!form.checkValidity()) {
                alertify.error("Fields can't be empty!");
                return false;
            }
            var currencies = [];
            $('.wcs-currencies').find('input[type="checkbox"]:checked').each(function(){
                var $this = $(this);
                currencies.push({
                    code: $this.val(),
                    name: $this.data('name')
                });
            });
            var mainTemplate = $('.wcs-template-main').val();
            var oneTemplate = $('.wcs-template-one').val();
            var activeTemplate = $('.wcs-template-active').val();

            var data = {
                currencies,
                mainTemplate,
                oneTemplate,
                activeTemplate
            };

            var params = {
                data,
                _ajax_nonce: wcsData.wcs_cs,
                action: 'wcs_settings',
            };

            $.post(ajaxurl, params, function(data){
                var res = data.data;
                if(data.success){
                    alertify.success(res.message);
                }else{
                    alertify.error(res.message);
                }
            });
        },
    };

    $(document).ready(function () {
        settingsForm.init();
    });
});