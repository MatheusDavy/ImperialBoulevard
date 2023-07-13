import MessageHandler from '../messageHandler';
import FormValidate from '../formValidateClass';
import AjaxClass from '../ajaxClass';
import '../Utils/inputMask'

export default function FormsContact () {
    $("#Form-Click").on('click', function (e) {
        $("#forms_contact").trigger('submit');
    });

    /*-------------/ Open Policy Privacy /--------------------*/
    const linkPolicyPrivacy = document.getElementById("link-policy-privacy")
    linkPolicyPrivacy.addEventListener("click", (e)=>{
        e.preventDefault()
        const modalPolicyPrivacy = document.getElementById("privacy-policy")
        modalPolicyPrivacy.classList.add("open-modal")
    })

    /*-------------/ Input Mask /--------------------*/
    $('#phone-input').mask('(00) 00000-0000')

    /*-------------/ Forms /--------------------*/
    $("#forms_contact").on('submit', function (e) {
        e.preventDefault();
        const Loader = document.getElementById("loading-forms")
        MessageHandler.removeAllFormFailMessages()
        let form = $(this);
        let terms = $("#confirm-terms").prop('checked') == true;
        let fields = form.serializeArray();

        let validation = new FormValidate(fields);
        validation.validateAll(fields);
        let error = validation.hasError();

        if (error) {
            let errorMessageId = validation.getErrorId();
            MessageHandler.showFailMessage(errorMessageId);
        }

        if (!error && !terms){
            error = true
            const id = ( $("#confirm-terms").attr('idError'))
            MessageHandler.showFailMessage(id);
            return false;
        }

        if (error == false) {
            Loader.classList.add("open-modal");
            if ($(this).attr('disabled') == 'disabled') {
                return false;
            }
            $(this).attr('disabled', 'disabled');
            let type = 'POST';
            let url = $(this).attr('action');
            let dataType = 'json';
            const modalSuccess = document.getElementById('success-message-forms');
            const modalError = document.getElementById('error-message-forms');
            const modalDescription = document.querySelector('#error-message-forms .description');
            class Contact extends AjaxClass {
                successFunction(data, form) {
                    Loader.classList.remove("open-modal");
                    if (data.status == true) {
                        $('#forms_contact').trigger("reset");
                        $("#forms_contact").removeAttr('disabled');
                        modalSuccess.classList.add("open-modal");
                    } else {
                        modalDescription.innerHTML = data.txt;
                        modalError.classList.add("open-modal");
                        $("#forms_contact").removeAttr('disabled');
                    }
                };
                errorFunction(xhr, textStatus, errorThrown){
                    Loader.classList.remove("open-modal");
                    modalDescription.innerHTML = "Ocorreu um erro. Tente novamente mais tarde.";
                    modalError.classList.add("open-modal");
                    $("#forms_contact").removeAttr('disabled');
                };
            }
            let ajax = new Contact(form, type, url, dataType, form.serialize());
            ajax.send();
        }
        return false;
    });
}