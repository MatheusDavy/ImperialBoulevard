@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6 mb-4' : 'col-sm-12 mb-4';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $name = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'].']['.$k.']' : $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';

    $image = isset($input['image']) && $input['image'] ? 'allow-image' : '';

    if (!$input['simpleCk']) {
        $lcol = 'd-none';
        $icol = 'col-sm-12';
    }

    $value = '';

    if($item){
        $value = $item->{$input['name']};
    }

    $folder = isset($input['folder']) ? $input['folder'] : '';
@endphp
<style>
    .ck-editor__editable[role="textbox"] {
        /* editing area */
        min-height: 200px;
    }
    .ck-content .image {
        /* block images */
        max-width: 80%;
        margin: 20px auto;
    }
</style>

<div class="form-group {{ $col }}">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}">{{ $input['title'] }}</label>
        </div>
        <div class="{{ $icol }}">
            <textarea simpleCk="{{$input['simpleCk']}}" name="{{ $name }}" class="ckeditor {{ $required }}" data-url="{{ route('adm.ckImageUpload') }}" data-folder="{{ $folder }}">
                {!! modelTranslate($value, $lang) !!}
            </textarea >
            @if (isset($input['alert']) && $input['alert'])
            <div class="alert alert-danger mt-2" role="alert">
                <b>Atencão: ao adicionar imagens, não ultrapasse 1MB por arquivo.</b>
            </div>
            @endif
        </div>
    </div>
</div>