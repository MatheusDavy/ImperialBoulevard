import AjaxClass from './ajaxClass';
import FormValidate from './formValidateClass';
import MessageHandler from './messageHandler';
export default function newsletter(){
    $("#newsletter-form").on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let fields = form.serializeArray();
        let checkbox = {'name': 'newscheck', 'value': ''};
        fields.push(checkbox);

        let validateClass = new FormValidate(fields);
        validateClass.validateAll();
        let error = validateClass.hasError();

        if (error) {
            let errorMessage = validateClass.getErrorMessage();
            let elementWithError = validateClass.getElement();
            MessageHandler.showFailMessage(errorMessage);
            // MessageHandler.showFormFailMessage(elementWithError, 'activate', errorMessage); <---- Novo padrão rdstation
        }

        if (!error) {
            let type = 'POST';
            let url = $(this).attr('action');
            let dataType = 'json';
            let ajax = new AjaxClass(form, type, url, dataType, form.serialize());
            ajax.send();
            // MessageHandler.removeAllFormFailMessages(); <---- Novo padrão rdstation
            MessageHandler.showSuccessMessage();
        }

        return false;
    });
}
