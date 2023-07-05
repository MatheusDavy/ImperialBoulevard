<div class="newslleter-component">
    <form class="form-news" id="newsletter-form" role="form" action={{route('site.newsletter')}} method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input id="cf-name" fieldName="Nome" name="name" type="text" autocomplete="off" placeholder="Name" isRequired="required">
        <div class="box_email">
            <input id="cf-email" type="text" fieldName="E-mail" fieldType="email" name="email" autocomplete="off" placeholder="Email" isRequired="required">
            <div>
                <input id="cf-newsletter-check" fieldName="Concordo em Receber comunicações" fieldType="checkbox" type="checkbox" name="newscheck" isRequired="required">
                <span id="cf-check-text">Eu concordo em receber comunicações.</span>
            </div>
            <button class="border border-dark" type="submit" id="btn-send">Submit</button>
        </div>
    </form>
</div>
