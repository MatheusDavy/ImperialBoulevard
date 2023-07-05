@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $name = $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';

    $value = isset($item->{$input['name']}) ? $item->{$input['name']} : '';
@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}">{{ $input['title'] }}</label>
        </div>
        <div class="{{ $icol }}">
            <input class="form-control input-date {{ $required }}" name="{{ $name }}" type="text" value="{{ $value }}" autocomplete="off">
        </div>
    </div>
</div>
