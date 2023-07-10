<form action="{{route('site.contact')}}" id="forms_contact" data-animation='right'>
    <div class="box_grid">
        <div class="input-group">
            <input fieldName="Name" idError='wwu-error-name' fieldType="name" isRequired="required" type="text" name="name" placeholder="Nome">
            <span class="error--message message-error-forms" id="wwu-error-name">Digite um nome válido !</span>
        </div>
        <div class="input-group">
            <input fieldName="Telefone" id="phone-input" idError='wwu-error-phone' fieldType="phone" isRequired="required" type="text" name="phone" placeholder="Telefone">
            <span class="error--message message-error-forms" id="wwu-error-phone">Digite um telefone válido !</span>
        </div>
    </div>
    <div class="input-group">
        <input fieldName="E-mail" idError='wwu-error-email' fieldType="email" isRequired="required" type="text" name="email" placeholder="Email">
        <span class="error--message message-error-forms" id="wwu-error-email">Digite um email válido !</span>
    </div>
    <div class="input-group">
        <textarea rows="1" fieldName="Mensagem" idError='wwu-error-subject' fieldType="notNull" isRequired="required" type="text" name="message" placeholder="Mensagem"></textarea>
        <span class="error--message message-error-forms" id="wwu-error-subject">Digite sua mensagem !</span>
    </div>

    <div class="checkbox-group">
        <div class="checkbox" style="font-size: 3vmin">
            <input type="checkbox" required/>
            <div class="check"></div>
        </div>
        <label for="checkbox">Ao informar meus dados, eu concordo com a <a href="">Política de Privacidade</a> e com os <a href="">Termos de Uso</a>.</label>
    </div>

    <button type="submit" hidden id="actual-submit">ENVIAR</button>
    <button type="button" id="Form-Click" class="btn-submit">ENVIAR</button>
</form>