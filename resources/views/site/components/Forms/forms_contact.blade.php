<form action="{{route('site.contact')}}" id="forms_contact" data-animation='right'>
    <div class="box_grid">
        <div class="input-group">
            <input autocomplete="off" fieldName="Name" idError='wwu-error-name' fieldType="name" isRequired="required" type="text" name="name" placeholder="Nome">
            <span class="error--message message-error-forms" id="wwu-error-name">Digite um nome válido !</span>
        </div>
        <div class="input-group">
            <input autocomplete="off" fieldName="Telefone" id="phone-input" idError='wwu-error-phone' fieldType="phone" isRequired="required" type="text" name="phone" placeholder="Telefone">
            <span class="error--message message-error-forms" id="wwu-error-phone">Digite um telefone válido !</span>
        </div>
    </div>
    <div class="input-group">
        <input autocomplete="off" fieldName="E-mail" idError='wwu-error-email' fieldType="email" isRequired="required" type="text" name="email" placeholder="Email">
        <span class="error--message message-error-forms" id="wwu-error-email">Digite um email válido !</span>
    </div>
    <div class="input-group">
        <textarea autocomplete="off" rows="1" fieldName="Mensagem" idError='wwu-error-subject' fieldType="notNull" isRequired="required" type="text" name="message" placeholder="Mensagem"></textarea>
        <span class="error--message message-error-forms" id="wwu-error-subject">Digite sua mensagem !</span>
    </div>
    <div class="checkbox-group">
        <div class="checkbox" style="font-size: 3vmin">
            <input id="confirm-terms" type="checkbox" fieldName="Termos" idError='wwu-error-terms' fieldType="checkbox" isRequired="required" name="checkbox" aria-label="Checkbox"/>
            <div class="check"></div>
        </div>
        <label for="checkbox">Ao informar meus dados, eu concordo com a <a href="/politica-de-provacidade" class="link-policy-privacy">Política de Privacidade</a></label>
        <span class="error--message message-error-forms" id="wwu-error-terms">Você deve aceitar nossa Política de Privacidade!</span>
    </div>
    <button type="submit" hidden id="actual-submit">ENVIAR</button>
    <button type="button" id="Form-Click" class="btn-submit">ENVIAR</button>
</form>