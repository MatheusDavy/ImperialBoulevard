<div class='error-message-forms' id="error-message-forms">
    <div class="error-message-forms--container">
        <button id='btn--close-error-message' class="close-error-message" aria-label="{{lang('Fechar Mensagem de Sucesso')}}">
            <ion-icon name="close-outline"></ion-icon> 
        </button>

        <div class="icon">
            <ion-icon name="close-outline"></ion-icon>
        </div>

        <p class="description">

        </p>

        <button class="confirm close-error-message" aria-label="Finalizar">Entendi</button>
    </div>
</div>

<script>
    $('.close-error-message').click(function() {
        const modal = document.getElementById('error-message-forms')
        modal.classList.remove("open-modal")
    });
</script>