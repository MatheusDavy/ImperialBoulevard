export default class AjaxClass {

    form;
    type;
    url;
    dataString;
    dataType;

    constructor(form, type, url, dataType, dataString) {
        this.form = form;
        this.type = type; //POST || GET
        this.url = url;
        this.dataString = dataString;
        this.dataType = dataType;
    }

    beforeSendFunction(){
        //
    };

    errorFunction(xhr, textStatus, errorThrown){
        $('.fail-message').html( `<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> Algo deu errado </div>` );
        $('.fail-message').fadeIn(1500, () => {
            $('.fail-message').fadeOut(1500);
        });
        $('.success-message').fadeOut(1500);
    };

    completeFunction(){
        //
    };

    successFunction(data, form){
        if (data.status == true) {
            $('.success-message').html( "<div><i class='fa-solid fa-circle-check'></i> <span>Seu cadastro foi realizado<br><b>com sucesso!</b></span></div>" );
            let formData = form.serializeArray();
            let inputName = '';
            formData.forEach(e => {
                inputName = $('[name="' + e['name'] + '"]');
                if (inputName.attr('type') == 'checkbox') {
                    inputName.prop('checked', false);
                }

                inputName.val('');
            });
            $('.success-message').fadeIn(1500, () => {
                $('.success-message').fadeOut(1500);
            });
            $('.fail-message').fadeOut(1500);
        } else {
            $('.fail-message').html( `<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> ${data.txt} </div>` );
            $('.fail-message').fadeIn(1500, () => {
                $('.fail-message').fadeOut(1500);
            });
            $('.success-message').fadeOut(1500);
        }
    };

    send() {
        let form = this.form;
        let beforeSendVar = this.beforeSendFunction;
        let successVar = this.successFunction;
        let errorVar = this.errorFunction;
        let completeVar = this.completeFunction;

        let type = this.type;
        let url = this.url;
        let datastring = this.dataString;
        let dataType = this.dataType;

        grecaptcha.ready(function () {
            grecaptcha.execute($("#recaptcha").val(), {
                action: 'submit'
            }).then(function (token) {
                datastring = datastring + '&gRecaptchaResponse='+ token;
                $.ajax({
                    type: type,
                    url: url,
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: datastring,
                    dataType: dataType,
                    beforeSend: function () {
                        beforeSendVar();
                    },
                    success: function (data) {
                        successVar(data, form);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        errorVar(xhr, textStatus, errorThrown);
                    },
                    complete: function () {
                        completeVar();
                    }
                });
            });
        });
    }
}