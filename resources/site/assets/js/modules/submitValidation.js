const prefix = "FORMS_VALIDATION_TYPE";
const TYPE_NAME = `${prefix}/NAME`;
const TYPE_EMAIL = `${prefix}/EMAIL`;
const TYPE_PHONE = `${prefix}/PHONE`;

const defaultClassActive = "activate";
const defaultClassError = "activate";

class ValidationForms {
    constructor(input, messageError_id, typeInput) {
        this.input = input;
        this.messageError = messageError_id;
        this.typeInput = typeInput;
        this.error = false;

        this.removeAllErrorMessage();
        this.validateInputsFields();
    }

    validateInputsFields() {
        switch (this.typeInput) {
            // The code will identify the input type and apply the correct validate
            case TYPE_NAME: {
                if (!isValidName(this.input) || this.input == "") {
                    this.showMessageError();
                    this.error = true;
                }

                break;
            }
            case TYPE_EMAIL: {
                if (!isValidEmail(this.input)) {
                    this.showMessageError();
                    this.error = true;
                }

                break;
            }

            case TYPE_PHONE: {
                break;
            }
        }
    }

    isValidEmail(emailAddress) {
        var pattern = new RegExp(
            /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i
        );
        return pattern.test(emailAddress);
    }

    isValidName(name) {
        const regexContainNumbers = /\d+/;
        const verifyRegex = regexContainNumbers.test(name);
        return verifyRegex;
    }

    // It will remove all error that be in screen
    removeAllErrorMessage() {
        const errorMessages = document.querySelectorAll(".messages--error");
        errorMessages.forEach((element) => {
            element.classList.remove(defaultClassError);
        });
    }
    // Show Message Error
    showMessageError() {
        const element = document.getElementById(this.messageError_id);
        element.classList.add(defaultClassActive);
    }

    return() {
        return this.error;
    }
}

export class SubmitFieldsToValidate {
    constructor(...inputs) {
        this.error = false;
        this.allFields = inputs;
        this.main();
    }

    main() {
        // Send all fields in Array to validate
        for (let i = 0; i < this.allFields.length; ) {
            // If haven´t no one error it will continue validate
            if (!this.error) {
                const { values, type, messageError_id } = this.allFields[i];
                this.error = new ValidationForms(
                    values,
                    messageError_id,
                    type
                ).return();
                i++;
            } else {
                // Case have one error this looping will be break
                break;
            }
        }

        this.submit();
    }

    submit() {
        const isItAllowedToSend = !this.error;
        return isItAllowedToSend;
    }
}

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

    beforeSendFunction() {
        //
    }

    errorFunction(xhr, textStatus, errorThrown) {
        $(".fail-message").html(
            `<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> Algo deu errado </div>`
        );
        $(".fail-message").fadeIn(1500, () => {
            $(".fail-message").fadeOut(1500);
        });
        $(".success-message").fadeOut(1500);
    }

    completeFunction() {
        //
    }

    successFunction(data, form) {
        if (data.status == true) {
            $(".success-message").html(
                "<div><i class='fa-solid fa-circle-check'></i> <span>Seu cadastro foi realizado<br><b>com sucesso!</b></span></div>"
            );
            let formData = form.serializeArray();
            let inputName = "";
            formData.forEach((e) => {
                inputName = $('[name="' + e["name"] + '"]');
                if (inputName.attr("type") == "checkbox") {
                    inputName.prop("checked", false);
                }

                inputName.val("");
            });
            $(".success-message").fadeIn(1500, () => {
                $(".success-message").fadeOut(1500);
            });
            $(".fail-message").fadeOut(1500);
        } else {
            $(".fail-message").html(
                `<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> ${data.txt} </div>`
            );
            $(".fail-message").fadeIn(1500, () => {
                $(".fail-message").fadeOut(1500);
            });
            $(".success-message").fadeOut(1500);
        }
    }

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
            grecaptcha
                .execute($("#recaptcha").val(), {
                    action: "submit",
                })
                .then(function (token) {
                    datastring = datastring + "&gRecaptchaResponse=" + token;
                    $.ajax({
                        type: type,
                        url: url,
                        headers: {
                            "X-CSRF-Token": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: datastring,
                        dataType: dataType,
                        beforeSend: function () {
                            beforeSendVar();
                        },
                        success: function (data) {
                            successVar(data, form);
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            errorVar(xhr, textStatus, errorThrown);
                        },
                        complete: function () {
                            completeVar();
                        },
                    });
                });
        });
    }
}

// Usage Example
/*
$("#contact-form").on('submit', function (e) {
        e.preventDefault();

        let fields = $(this).serialize()

        var email = {
            values: $("#ct-email").val(),
            type: TYPE_EMAIL,
            messageError_id: 'ms-email'
        }
        
        var name = {
            values: $("#ct-name").val(),
            type: TYPE_NAME, 
            messageError_id: 'ms-name'
        }

        const isItAllowedToSend = new SubmitFieldsToValidate(email, name)
        
        if (isItAllowedToSend) {
            let type = 'POST';
            let url = $(this).attr('action');
            let dataType = 'json';
            let ajax = new AjaxClass(form, type, url, dataType, fields);
            ajax.send();
        }

        return false;
    });

*/
