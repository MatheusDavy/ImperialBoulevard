@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-6';
    $hasUrl = (isset($input['url']) && $input['url']);
    $url = $hasUrl ? $input['url'] : '#';

    $name = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'].']['.$k.']' : $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';
    $class = isset($input['class']) && $input['class'] ? $input['class'] : '';
    $mask = isset($input['mask']) && $input['mask'] ? $input['mask'] : '';

    if ($hasUrl == false) {
        $class = 'd-none';
    }

    $value = '';

@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="col-sm-6">
            <a
                href={{$url}} target="_blank" style="min-width: 80px; padding: 0px 0px; background-color: #5664d2;"
                data-toggle="tooltip" data-placement="top" title="Ver Rascunho"
                class="badge badge-primary{{ $required }} {{ $class }} {{ $mask ? 'input-mask' : '' }}"
            >
               <p style="margin: revert"><i style="font-size: 20px" class="fa-solid fa-file-pen"></i></p>
            </a>
        </div>
    </div>
</div>
