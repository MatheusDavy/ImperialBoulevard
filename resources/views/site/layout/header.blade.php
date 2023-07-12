<header id="header" class="header" data-animation>
    <div class="header--container">
        <a href="{{route('site.home')}}" aria-label="Ir para Home">
            <img class="logo" src="{{ asset('site/img/Header/boulevard-logo.png') }}" alt="Logo Boulevard">
        </a>

        <button class="menu-button" aria-label="Abrir/Fechar o Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="menu-content">
            <nav class="menu-content--nav">
                <ul class="menu-content--list">
                    <li class="menu-content--item"> <a href="{{route('site.home')}}/#inicio">INICIO</a></li>
                    <li class="menu-content--item"> <a href="{{route('site.home')}}/#regiao">A REGIÃO</a></li>
                    <li class="menu-content--item"> <a href="{{route('site.home')}}/#boulevard-convention">BOULEVARD CONVENTION</a></li>
                    <li class="menu-content--item"> <a href="{{route('site.home')}}/#meeting-plus">MEETING PLUS</a></li>
                    <li class="menu-content--item"> <a href="{{route('site.home')}}/#diferenciais">DIFERENCIAIS</a></li>
                    <li class="menu-content--item"> <a href="{{route('site.home')}}/#invista">INVISTA</a></li>
                    <li class="menu-content--item"> <a href="{{route('site.home')}}/#contato">CONTATO</a></li>
                    <li class="menu-content--item"> <a href="{{route('site.offers')}}">OFERTAS PÚBLICAS</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>