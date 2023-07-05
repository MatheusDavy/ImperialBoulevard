"use strict";
var authForms;

function AuthForms() {
	this.init();
};

AuthForms.prototype.init = function(){
	var self = this;

	self.authForms();

	self.notyf = new Notyf();
}
AuthForms.prototype.authForms = function(){
    //Criar Token
    $('body').on('submit', '#createToken', function (event) {
        event.preventDefault();
        var btn = $(this);
        $.ajax({
            url: btn.attr('url'),
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            error: function () {
                authForms.notyf.error({
                    message: "Algo deu errado na criação do token.",
                    duration: 4000
                });
            },
            success: function () {
                authForms.notyf.success({
                    message: "Token criado com sucesso.",
                    duration: 2000
                });
            }
        }).done( () => {
            document.location.reload(true);
        });
    });

    //Login
    $('#login-form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $("#baseLogin").val(),
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            data: 'email=' + $('#email').val() + '&password=' + $('#password').val(),
            dataType: 'json',
            success: function (json) {
                authForms.notyf.success({
                    message: "Login realizado com sucesso!",
                    duration: 2000
                });
                if (json.two_factor) {
                    window.location.href = $("#twoFactorUrl").val();
                } else {
                    document.location.reload(true);
                }
            },
            error: function (json) {
                let obj = json.responseJSON.errors;
                let li = '';
                Object.values(obj).forEach(val => {
                    li += '<li>' + val + '</li>';
                });
                authForms.notyf.error({
                    message: li,
                    duration: 4000
                });
            }
        });
    });

    //Confirmar Senha
    $('body').on('submit', '#passConfirm', function (e) {
        e.preventDefault();
        var form = $(this);

        $.ajax({
            url: form.attr('url'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            error: function () {
                authForms.notyf.error({
                    message: "Algo deu errado na confirmação de senha.",
                    duration: 4000
                });
            },
            success: function () {
                authForms.notyf.success({
                    message: "Senha confirmada.",
                    duration: 2000
                });
            }
        }).done( () => {
            if ($("#passConfirm").attr('confirmPage')) {
                window.location.href= $("#baseDash").val();
            } else {
                document.location.reload(true);
            }
        });
    });

    //Autenticação de dois fatores
    $('body').on('submit', '#twoFactor', function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('url'),
            type: 'POST',
            data: form.serialize,
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            error: function (json) {
                let message = json.responseJSON.message;
                if (message == 'Password confirmation required.') {
                    message = 'Confirmação de senha necessária.'
                    $("#passConfirmButton").click();
                    $("#closeFactorButton").click();
                }

                authForms.notyf.error({
                    message: message,
                    duration: 4000
                });
            },
            success: function () {
                authForms.notyf.success({
                    message: "Autenticação de dois Fatores ativada.",
                    duration: 2000
                });
                $.ajax({
                    url: $("#qrUrl").val(),
                    type: 'GET',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    error: function () {
                        let message = 'Erro ao buscar Qrcode de autenticação.';

                        authForms.notyf.error({
                            message: message,
                            duration: 4000
                        });
                    },
                    success: function (json) {
                        let svg = json.svg;
                        $("#factorBody").css({'display': 'flex', 'justify-content': 'center'});
                        $("#factorBody").html(
                            `
                                <div class="col-12" style="display:flex;justify-content:center;">${svg}</div>
                                <div class="col-12 mt-2">
                                    <h5 style="margin-bottom: 0.5rem">Preencha o campo abaixo:</h5>
                                    <input type="text" class="form-control required" name="code" placeholder="Código válido de autenticação">
                                </div>
                            `
                        );
                        $("#twoFactor").attr('url', $("#baseTwoFactor").val());
                        $("#twoFactor").attr('id', 'twoFactorSendCode');
                        authForms.notyf.success({
                            message: "QrCode disponível",
                            duration: 2000
                        });
                    }
                });
            }
        });
    });

    //Enviando código de dois fatores do user
    $('body').on('submit', '#twoFactorSendCode', function (e) {
        e.preventDefault();
        var form = $(this);
        console.log(form.serialize());
        $.ajax({
            url: form.attr('url'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            error: function (json) {
                let message = json.responseJSON.message;
                if (message == 'The given data was invalid.') {
                    message = 'Código inválido.'
                }

                authForms.notyf.error({
                    message: message,
                    duration: 4000
                });
            },
            success: function () {
                authForms.notyf.success({
                    message: "Código de Autenticação de dois Fatores Enviado.",
                    duration: 2000
                });
            }
        }).done( () => {
            document.location.reload(true);
        });
    });

    //Desativar Autenticação de dois fatores
    $('body').on('click', '#twoFactorDelete', function (e) {
        e.preventDefault();
        var btn = $(this);
        $.ajax({
            url: btn.attr('url'),
            type: 'DELETE',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            error: function (json) {
                let message = json.responseJSON.message;
                if (message == 'Password confirmation required.') {
                    message = 'Confirmação de senha necessária.'
                    $("#passConfirmButton").click();
                    $("#closeFactorButton").click();
                }

                authForms.notyf.error({
                    message: message,
                    duration: 4000
                });
            },
            success: function () {
                authForms.notyf.success({
                    message: "Autenticação de dois Fatores desativada.",
                    duration: 2000
                });
            }
        }).done( () => {
            document.location.reload(true);
        });
    });

    //envio de código de autenticação por email
    $('body').on('submit', '#forgotCode', function (e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('url'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            error: function (json) {
                let message = json.responseJSON.message;

                authForms.notyf.error({
                    message: message,
                    duration: 4000
                });
            },
            success: function (json) {
                let message = json.message;
                let codeInput = `<div class="input-group mb-4 column">
                    <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                    </div>
                    <input id="recovery_code" type="password" class="form-control required"
                            name="recovery_code" placeholder="Código de recuperação">
                </div>`;
                $("#codeFields").html(codeInput);
                $("#textFields").text('Informe o código de Recuperação enviado para seu email.');
                authForms.notyf.success({
                    message: message,
                    duration: 2000
                });
            }
        });
    });
}
$(document).ready(function(){
	authForms = new AuthForms();
});
