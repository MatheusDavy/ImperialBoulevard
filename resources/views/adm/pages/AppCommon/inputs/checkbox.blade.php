@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $name = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'].']['.$k.']' : $input['name'];

    $checked = false;

    if($item){
        $checked = ($item->{$input['name']} == '1');
    }
@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row">
        <div class="{{ $lcol }}">
            <label class="col-form-label">{{ $input['title'] }}</label>
        </div>
        <div class="{{ $icol }}">
            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input" id="checkbox_{{ $name }}" name="{{ $name }}" {{ $checked ? 'checked' : ''}}>
                <label class="custom-control-label" for="checkbox_{{ $name }}"></label>
            </div>
        </div>
    </div>
</div>
