<div class='success-message-forms' id="success-message-forms">
    <div class="success-message-forms--container">
        <button id='btn--close-success-message' class="close-success-message" aria-label="Fechar Mensagem">
            <ion-icon name="close-outline"></ion-icon> 
        </button>

        <div class="icon">
            <ion-icon name="checkmark-outline"></ion-icon>
        </div>

        <p class="description">
            Obrigado por entrar em contato, nossa equipe entrará em contato.
            Fique atento aos meios de comunicações informados
        </p>

        <button class="confirm close-success-message" aria-label="Finalizar">Entendi</button>
    </div>
</div>

<script>
    $('.close-success-message').click(function() {
        const modal = document.getElementById('success-message-forms')
        modal.classList.remove("open-modal")
    });
</script>