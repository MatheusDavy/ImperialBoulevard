<style>
    .modal-crop {
        padding: 15px !important;
    }
    .cropper-container.cropper-bg {
        max-width: -webkit-fill-available;
        overflow: hidden;
    }
    .modal-dialog-size {
        max-width: 100%;
        max-height: 100%;
        margin: 0rem;
    }
    .body-col-size {
        padding: 1rem !important;
        margin: 0rem !important;
    }
    .body-col-size-padding {
        padding: 1rem !important;
        margin: 0rem !important;
        padding-right: 0px !important
    }
    .cropDiv {
        justify-content: center;
        row-gap: 5px;
    }
    .hstack-crop {
        justify-content: flex-end;
        margin-left: 15px;
    }
    .cancel-btn-crop {
        color: #5c6873;
        background-color: #f0f3f5;
    }
    .success-btn-crop {
        margin-left: 5px;
    }
    .fit-height {
        height: fit-content;
    }

    .crop-input-gap {
        gap: 10px;
    }

    .col-inputs {
        max-height: 65vh;
        position: sticky;
        top: 5px;
    }
</style>
@if (!checkMobile())
<div class="modal-dialog modal-lg modal-dialog-size" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Imagem Crop</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body text-center row">
            <div class="col-3 row body-col-size-padding col-inputs">
                <div class="col-12 row">
                    <div class="col-12 input-group fit-height">
                        <span class="input-group-text"><b>Atual</b></span>
                        <input readonly type="text" aria-label="Largura" id="widthCounter" class="form-control">
                        <input readonly type="text" aria-label="Altura" id="heightCounter" class="form-control">
                    </div>
                    <div class="col-12 input-group fit-height">
                        <span class="input-group-text"><b>Recomendado</b></span>
                        <input type="text" readonly aria-label="Largura" id="widthRecommended" class="form-control">
                        <input type="text" readonly aria-label="Altura" id="heightRecommended" class="form-control">
                    </div>
                </div>
                <div class="col-12 row">
                    <div class="col-12 input-group fit-height">
                        <span class="input-group-text"><b>Alterar L | A</b></span>
                        <input type="number" dimensionInput aria-label="Largura" value="1920" id="dimensionW" class="form-control">
                        <input type="number" dimensionInput aria-label="Altura" value="1036" id="dimensionH" class="form-control">
                    </div>
                    <div class="col-12 d-flex justify-content-start input-group fit-height">
                        <span class="input-group-text"><b>Aspect Ratio</b></span>
                        <select class="col-6 form-select form-select-sm" name="aspect" aria-label="Selecione o aspect ratio">
                            <option value="16:9">16:9</option>
                            <option value="4:3">4:3</option>
                            <option value="1:1">1:1</option>
                            <option value="2:3">2:3</option>
                            <option value="Livre">Livre</option>
                        </select>
                    </div>
                </div>
                <div class="col row">
                    <div class="col">
                        <button type="button" class="btn btn-primary" style="background-color: #20a8d8;" id="buttonZoomLess"> - Zoom</button>
                        <div class="cr-slider-wrap">
                            <input class="cr-slider" type="range" step="0.01" aria-label="zoom" min="0.2" max="1.8" aria-valuenow="1">
                        </div>
                        <button type="button" class="btn btn-primary" style="background-color: #20a8d8;" id="buttonZoomMore"> + Zoom</button>
                    </div>
                </div>
            </div>
            <div class="col-9 body-col-size imageDiv">
                <div id="cropDiv" class="row container d-flex cropDiv"></div>
            </div>
            <div class="col row pt-2 body-col-size">
                <div class="col-12 d-flex hstack gap-2 hstack-crop">
                    <button type="button" class="btn btn-secondary cancel-btn-crop" data-dismiss="modal" aria-label="Close">Cancelar</button>
                    <button type="button" class="btn btn-success success-btn-crop" id="getCrop">Salvar Imagem</button>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="modal-dialog modal-lg modal-dialog-size" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Imagem Crop</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body text-center row">
            <div class="col-12 body-col-size imageDiv">
                <div id="cropDiv" class="row container d-flex cropDiv"></div>
            </div>
            <div class="col-12 row body-col-size-padding crop-input-gap">
                <div class="col-12 row crop-input-gap">
                    <div class="col-12 input-group fit-height">
                        <span class="input-group-text"><b>Atual</b></span>
                        <input readonly type="text" aria-label="Largura" id="widthCounter" class="form-control">
                        <input readonly type="text" aria-label="Altura" id="heightCounter" class="form-control">
                    </div>
                    <div class="col-12 input-group fit-height">
                        <span class="input-group-text"><b>Recomendado</b></span>
                        <input type="text" readonly aria-label="Largura" id="widthRecommended" class="form-control">
                        <input type="text" readonly aria-label="Altura" id="heightRecommended" class="form-control">
                    </div>
                </div>
                <div class="col-12 row crop-input-gap">
                    <div class="col-12 input-group fit-height">
                        <span class="input-group-text"><b>Alterar L | A</b></span>
                        <input type="number" dimensionInput aria-label="Largura" value="1920" id="dimensionW" class="form-control">
                        <input type="number" dimensionInput aria-label="Altura" value="1036" id="dimensionH" class="form-control">
                    </div>
                    <div class="col-12 d-flex justify-content-start input-group fit-height">
                        <span class="input-group-text"><b>Aspect Ratio</b></span>
                        <select class="col-6 form-select form-select-sm" name="aspect" aria-label="Selecione o aspect ratio">
                            <option value="16:9">16:9</option>
                            <option value="4:3">4:3</option>
                            <option value="1:1">1:1</option>
                            <option value="2:3">2:3</option>
                            <option value="Livre">Livre</option>
                        </select>
                    </div>
                </div>
                <div class="col row">
                    <div class="col">
                        <button type="button" class="btn btn-primary" style="background-color: #20a8d8;" id="buttonZoomLess"> - Zoom</button>
                        <div class="cr-slider-wrap">
                            <input class="cr-slider" type="range" step="0.01" aria-label="zoom" min="0.2" max="1.8" aria-valuenow="1">
                        </div>
                        <button type="button" class="btn btn-primary" style="background-color: #20a8d8;" id="buttonZoomMore"> + Zoom</button>
                    </div>
                </div>
            </div>
            <div class="col row pt-2 body-col-size">
                <div class="col-12 d-flex hstack gap-2 hstack-crop">
                    <button type="button" class="btn btn-secondary cancel-btn-crop" data-dismiss="modal" aria-label="Close">Cancelar</button>
                    <button type="button" class="btn btn-success success-btn-crop" id="getCrop">Salvar Imagem</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif