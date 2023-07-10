export default class MessageHandler {

    static showFailMessage(id, showModal = true){
        let errorMessage =  document.getElementById(id)
        $('.show--error').removeClass('show--error');
        errorMessage.parentNode.classList.add("show--error")
        if(showModal) this.showErrorModal(id)
    }

    static showErrorModal(id){
        const message =  document.getElementById(id).innerHTML
        const modal = document.getElementById('error-message-forms')
        const modalDescription = document.querySelector('#error-message-forms .description')

        modalDescription.innerHTML = message
        modal.classList.add("open-modal")
    }


    static removeAllFormFailMessages(selector = ".message-error-removed", elementClass = 'activate'){
        const inputGroup = document.querySelectorAll(selector);
        inputGroup.forEach(group => {
            group.classList.remove(elementClass);
        })
    }
}