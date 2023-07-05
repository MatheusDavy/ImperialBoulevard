@php
    $required = isset($input['required']) && $input['required'] ? 'required' : '';
    $itens = isset($item->{$input['name']}) ? $item->{$input['name']} : [];
@endphp
<div class="gallery-input {{ $required }} {{ $itens ? 'filled' : '' }}" data-name="{{ $input['name'] }}" data-url="{{ route('adm.upload') }}">
    <div class="top">
        <label id="addRelated" class="btn btn-success add-images">
            <input type="text" name="file" multiple>
            <i class="fas fa-images"></i>
            <span>Adicionar</span>
        </label>
        <div class="btn btn-danger remove-images">
            <i class="fas fa-trash"></i>
            <span>Remover Selecionadas</span>
        </div>
    </div>
    <div id="relatedFormGroup" class="form-group">
        @foreach ($itens as $related)
            <div class="item">
                <input type="text" class="form-control title" name="{{ $input['name'] }}[title][]" value="{{ $related->title }}">
                <label class="checkbox"><input type="checkbox" class="gallery-checkbox"><span class="icon"></span></label>
            </div>
        @endforeach
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$('#addRelated').click(function() {
    let data = `<div class="item">
            <input type="text" class="form-control title" name="{{ $input['name'] }}[title][]" value="">
            <label class="checkbox"><input type="checkbox" class="gallery-checkbox"><span class="icon"></span></label>
        </div>`
    $('#relatedFormGroup').append(data);
});
</script>
