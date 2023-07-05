"use strict";
var inputsCommon;

function InputsCommon() {
	this.init();
};

InputsCommon.prototype.init = function(){
	var self = this;
	self.inputsCommon();
    self.cropConfig();
}
InputsCommon.prototype.inputsCommon = function(){
    //input link
    $('body').on('keyup', '[linkMask]', function () {
        let linkValue = $(this).val();
        if (!linkValue.match("^https://") && !linkValue.match("^http://")) {
            $(this).val('https://' + linkValue);
        }
    });

    $(".js-example-tokenizer").select2({
        tags: true,
        tokenSeparators: [',']
    });
}
InputsCommon.prototype.cropConfig = function(){
    
    let cropConfig = localStorage.getItem('cropConfig');
    if (cropConfig == 'false') cropConfig = false;
    if (cropConfig == 'true') cropConfig = true;

    if (!cropConfig) {
        $("#cropConfig").prop('checked', false);
    } else {
        $("#cropConfig").prop('checked', true);
    }

    $('body').on('change', '#cropConfig', function () {
        if ($("#cropConfig").prop('checked')) {
            localStorage.setItem('cropConfig', true);
        } else {
            localStorage.setItem('cropConfig', false);
        }
    });
}
$(document).ready(function(){
	inputsCommon = new InputsCommon();
});
