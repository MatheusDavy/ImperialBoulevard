import mask from 'jquery-mask-plugin'

/*
    SUMMARY

    1 - Mask Inputs
        1.1 - FORMATERS
        1.2 - PHONES
        1.3 - CPF / CNPJ
    2 - Form

*/


export default function contactForm(){
    /*----------------------- 1 - Mask Inputs ---------------------------*/
    // 1.1 - FORMATERS
    const formaterNumber = '(00) 00000-0000'
    const formaterCPF = '000.000.000-00'
    const formaterCNPJ = '00.000.000/0000-00'

    // 1.2 - PHONES
    const numberValidation = formaterNumber.length
    $("#ct-phone").mask(formaterNumber)

    // 1.3 - CPF / CNPJ
    let cpfCnpjValidation = 0
    const inputCnpjCpf = document.getElementById('ct-cpf_cnpf')
    inputCnpjCpf.addEventListener('input', transformMaskCPF_CNPJ)
    function transformMaskCPF_CNPJ(){
        const length = inputCnpjCpf.value.length
        if(length <= 14) {
            $("#ct-cpf_cnpf").mask(`${formaterCPF}""`)
            cpfCnpjValidation = 14
        }else{
            $("#ct-cpf_cnpf").mask(formaterCNPJ)
            cpfCnpjValidation = 18
        }
    }

     /*----------------------- 2 - Mask Inputs ---------------------------*/
    $("#contact-form").on('submit', function (e) {
        e.preventDefault();
        var email = $("#ct-email").val();
        var name = $("#ct-name").val();
        let phone = $("#ct-phone").val();
        let cpf_cnpf = $("#ct-cpf_cnpf").val();
        let subject = $("#ct-subject").val();
        let message = $("#ct-message").val();

        let cleanPhone = phone.replace(/[_\W]+/g, "").trim();

        function isValidEmail(emailAddress) {
            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
            return pattern.test(emailAddress);
        };

        let error = false;

        if (isValidEmail(email) == false) {
            error = true;
            $('.fail-message').html( "<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> <span>Formato inválido de email </div>" );
        }

        if (name == '') {
            error = true;
            $('.fail-message').html( "<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> Nome precisa ser preenchido </div>" );
        }

        if(cpf_cnpf == ''){
            error = true;
            $('.fail-message').html( "<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> CPF/CNPJ precisa ser preenchido </div>" );

        }else if(cpf_cnpf.length !== cpfCnpjValidation && cpfCnpjValidation == 14){
            error = true;
            $('.fail-message').html( "<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> número de CPF inválido </div>" );

        }else if(cpf_cnpf.length !== cpfCnpjValidation && cpfCnpjValidation == 18){
            error = true;
            $('.fail-message').html( "<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> número de CNPJ inválido </div>" );
        }

        if (subject == '') {
            error = true;
            $('.fail-message').html( "<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> Assunto precisa ser preenchido </div>" );
        }

        if(phone == '' || phone.length !== numberValidation)

        var url = $(this).attr('action');

        if (!error) {
            grecaptcha.ready(function () {
                grecaptcha.execute($("#recaptcha").val(), {
                  action: 'submit'
                }).then(function (token) {
                    var dataString = 'name=' + name + '&email=' + email + '&phone=' + phone + '&subject=' + subject + '&message=' + message + '&gRecaptchaResponse='+ token;
                    $.ajax({
                        type: "POST",
                        url: url,
                        headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: dataString,
                        dataType: 'json',
                        success: function (json) {
                            if (json.status == true) {
                                $('.success-message').html( "<div><i class='fa-solid fa-circle-check'></i> <span>Seu cadastro foi realizado<br><b>com sucesso!</b></span></div>" );
                                $("#ct-email").val('');
                                $("#ct-name").val('');
                                $("#ct-phone").val('');
                                $("#ct-subject").val('');
                                $("#ct-message").val('');
                                $('.success-message').fadeIn(500, () => {
                                    $('.success-message').fadeOut(500);
                                });
                                $('.fail-message').fadeOut(500);
                            } else {
                                $('.fail-message').html( `<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> ${json.txt} </div>` );
                                $('.fail-message').fadeIn(500, () => {
                                    $('.fail-message').fadeOut(500);
                                });
                                $('.success-message').fadeOut(500);
                            }
                        }
                    });
                });
            });
        }
        else {
            $('.fail-message').fadeIn(500, () => {
                $('.fail-message').fadeOut(500);
            });
            $('.success-message').fadeOut(500);
        }
        return false;
      });
    }
