<div id="modal-zoom-plant">
    <button id="btn-close__zoom-modal-plant" aria-label="Fechar imagem ampliada">
        <ion-icon name="close-outline"></ion-icon>
    </button>

    <div class="description active">
        <div class="phone">
        </div>
        <div class="message">
            Vire seu dispositivo verticalmente <br>
            (Habilite a rotação do seu dispositivo)
        </div>
    </div>

    <div class="image">
        <img src="{{ assetJson([$fourthSection->folder,$fourthSection->image_2]) }}" alt="{{imgAltJson($fourthSection->image_2)}}" title="{{imgTitleJson($fourthSection->image_2)}}">
    </div>
</div>