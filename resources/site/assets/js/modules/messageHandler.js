export default class MessageHandler {

    static showSuccessMessage(message = ''){}

    static showFailMessage(message = 'Preencha todos os Campos'){
        $('.fail-message').html( `<div class='danger-box'><i class='fa-solid fa-circle-xmark'></i> <span> ${message} </div>` );
        $('.fail-message').fadeIn(1500, () => {
            $('.fail-message').fadeOut(1500);
        });
        $('.success-message').fadeOut(1500);
    }

    static showFormSuccessMessage(message = ''){}

    static showFormFailMessage(element, elementClass = 'activate', message = ''){
        $(element).addClass(elementClass);
    }

    static removeAllFormFailMessages(selector = ".message-error-removed", elementClass = 'activate'){
        const inputGroup = document.querySelectorAll(selector);
        inputGroup.forEach(group => {
            group.classList.remove(elementClass);
        })
    }
}