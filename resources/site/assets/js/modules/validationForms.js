export default class FormValidate {

    fields;
    lang;
    error;
    errorMessage;
    element;

    //fields = form.serializeArray()
    constructor(fields, lang = 1) {
        this.fields = fields;
        this.lang = lang;
        this.error = false;
        this.errorMessage = '';
    }

    validateAll() {
        this.fields.forEach(field => {
            if (this.hasError()) {
                return;
            }
            this.validateField(field);
        });
    }

    validateField(field) {
        let element = $('[name="' + field['name'] + '"]');
        this.element = element;
        let value = field['value'];

        if (this.fieldIsNotRequired(element) || field['name'] == '_token') {
            return;
        }

        let fieldName = element.attr('fieldName');
        let fieldType = element.attr('fieldType');

        if (!value && fieldType !== 'checkbox') {
            this.error = true;
            this.errorMessage = this.notFilledMessage(fieldName);
            return;
        }

        if (fieldType == 'email') {
            this.error = FormValidate.validateEmail(value);
            this.errorMessage = this.notFilledMessage(fieldName);
            return;
        }

        if (fieldType == 'checkbox') {
            let checked = FormValidate.validateCheckboxIsChecked(element);
            if (!checked) {
                this.error = true;
            }
            this.errorMessage = this.notFilledMessage(fieldName);
            return;
        }

        if (fieldType == 'cnpj') {
            this.error = FormValidate.validateCNPJ(value);
            this.errorMessage = this.invalidMessage(fieldName);
            return;
        }

        if (fieldType == 'cpf') {
            this.error = FormValidate.validateCPF(value);
            this.errorMessage = this.invalidMessage(fieldName);
            return;
        }

        if (fieldType == 'cnpj|cpf') {
            this.error = FormValidate.validateCNPJ_CPF(value);
            this.errorMessage = this.invalidMessage(fieldName);
            return;
        }

        return;
    }

    hasError() {
        return this.error == true;
    }

    getErrorMessage() {
        let message = this.errorMessage;
        if (!message) {
            return false;
        }

        return message;
    }

    getElement() {
        return this.element;
    }

    invalidMessage(fieldName) {
        let message = `Formato inválido de ${fieldName}`;

        if (this.lang == 'en' || this.lang == 2) {
            message = `Invalid ${fieldName} format.`;
        }

        if (this.lang == 'es' || this.lang == 3) {
            message = `Formato de ${fieldName} no válido.`;
        }

        return message;
    }

    notFilledMessage(fieldName) {
        let message = `O campo ${fieldName} precisa ser preenchido.`;

        if (this.lang == 'en' || this.lang == 2) {
            message = `The field ${fieldName} needs to be filled in.`;
        }

        if (this.lang == 'es' || this.lang == 3) {
            message = `El campo de ${fieldName} debe completarse.`;
        }

        return message;
    }

    fieldIsNotRequired(element) {
        return element.attr('isRequired') == false;
    }

    static validateEmail(email) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(email) == false;
    }

    static validateCheckboxIsChecked(element) {
        return element.prop('checked') == true;
    }

    static validateCPF(cpf) {
        let cpfLength = 14;
        if (cpf.length == cpfLength) {
            return true;
        }

        return false;
    }

    static validateCNPJ(cnpj) {
        let cnpjLength = 18;
        if (cnpj.length == cnpjLength) {
            return true;
        }

        return false;
    }

    static validateCNPJ_CPF(cpfOrcnpj) {
        let isCpf = FormValidate.validateCPF(cpfOrcnpj);
        let isCnpj = FormValidate.validateCNPJ(cpfOrcnpj);
        if (isCpf || isCnpj) {
            return true;
        }

        return false;
    }
}