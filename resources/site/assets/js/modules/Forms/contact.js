import MessageHandler from '../messageHandler';
import FormValidate from '../formValidateClass';
import AjaxClass from '../ajaxClass';
import '../Utils/inputMask'

export default function FormsContact () {
    $("#Form-Click").on('click', function (e) {
        $("#forms_contact").trigger('submit');
    });

    /*-------------/ Input Mask /--------------------*/
    $('#phone-input').mask('(00) 00000-0000')

    /*-------------/ Forms /--------------------*/
    $("#forms_contact").on('submit', function (e) {
        e.preventDefault();
        MessageHandler.removeAllFormFailMessages()
        let form = $(this);
        let fields = form.serializeArray();

        let validation = new FormValidate(fields);
        validation.validateAll(fields);
        let error = validation.hasError();

        if (error) {
            let errorMessageId = validation.getErrorId();
            MessageHandler.showFailMessage(errorMessageId);
        }

        if (!error) {
            $(this).attr('disabled', 'disabled');
            $("#Form-Click").attr('disabled', 'disabled');
            let type = 'POST';
            let url = $(this).attr('action');
            let dataType = 'json';
            const modal = document.getElementById('error-message-forms');
            const modalDescription = document.querySelector('#error-message-forms .description');
            class Contact extends AjaxClass {
                successFunction(data, form) {
                    if (data.status == true) {
                        $('#forms_contact').trigger("reset");
                        modalDescription.innerHTML = data.txt;
                        modal.classList.add("open-modal");
                    } else {
                        modalDescription.innerHTML = data.txt;
                        modal.classList.add("open-modal");
                    }
                };
            }
            let ajax = new Contact(form, type, url, dataType, form.serialize());
            ajax.send();
            setTimeout(() => {
                $("#Form-Click").removeAttr('disabled');
                $(this).removeAttr('disabled');
            }, 2000);
        }
        return false;
    });
}