export default class FormValidate {

    fields;
    lang;
    error;
    errorMessageId;
    element;

    //fields = form.serializeArray()
    constructor(fields, lang = 1) {
        this.fields = fields;
        this.lang = lang;
        this.error = false;
        this.errorMessageId = '';
        this.element
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
        let fiedlIdError = element.attr("idError")
        if (!fiedlIdError) {
            fiedlIdError = element.attr("name");
        }

        switch (fieldType) {
            case 'email': {
                this.error = FormValidate.validateEmail(value);
                this.errorMessageId = fiedlIdError;
                return;
            }
            case 'checkbox': {
                let checked = FormValidate.validateCheckboxIsChecked(element);
                if (!checked) {
                    this.error = true;
                }
                this.errorMessageId = fiedlIdError;
                return;
            }
            case 'phone': {
                this.error = FormValidate.validatePhone(value);
                this.errorMessageId = fiedlIdError;
                
                return;
            }
            case 'notNull': {
                this.error = FormValidate.validateNotNull(value);
                this.errorMessageId = fiedlIdError;
                
                return;
            }
            case 'name': {
                this.error = FormValidate.validateName(value);
                this.errorMessageId = fiedlIdError;
                return;
            }
        }

        return;
    }

    hasError() {
        return this.error;
    }

    getErrorId() {
        let id = this.errorMessageId;
        if (!id) {
            return false;
        }

        return id;
    }

    getElement() {
        return this.element;
    }

    fieldIsNotRequired(element) {
        return element.attr('isRequired') == null;
    }

    static validateEmail(email) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(email) == false;
    }

    static validateCheckboxIsChecked(element) {
        return element.prop('checked') == true;
    }

    static validateName(name) {
        const regex = /[0-9]/;
        if (regex.test(name) || name.length < 3) {
            return true;
        }
        return false;
    }

    static validateNotNull(value) {
        const verify = value == '' ? true : false
        return verify;
    }

    static validatePhone(value) {
        const verify = value == '' || value.length < 14 ? true : false
        return verify;
    }


}