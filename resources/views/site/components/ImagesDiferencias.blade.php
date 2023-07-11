<img loading="lazy" src="{{ assetJson([$fifthSection->folder,$gallery->image]) }}" alt="{{imgAltJson($gallery->image)}}" 
										title="{{imgTitleJson($gallery->image)}}">
<div class="image-description">
    <button class="image-description--zoom images--zoom" data-src="{{ assetJson([$fifthSection->folder,$gallery->image]) }}" aria-label="Ver imagem ampliada">
        <img loading="lazy" src="{{ asset('site/img/Home/Differentials/zoom.svg') }}" alt="">
    </button>

    <p class="image-description--description">
        {{$gallery->title ? $gallery->title : "Integração com espaços para eventos"}}
    </p>
</div>