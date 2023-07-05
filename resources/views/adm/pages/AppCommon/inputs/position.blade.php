@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $required = isset($input['required']) && $input['required'] ? 'required' : '';

    $value = '';

    if($item){
        $value = $item->{$input['name']};
    }
@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}">{{ $input['title'] }}</label>
        </div>
        <div class="{{ $icol }}">
            <div class="pick-position {{ $required ? $required.' filled' : '' }} {{ $value ? 'filled' : '' }}" data-name="{{ $input['name'] }}">
                @if($value)
                    <input type="hidden" name="{{ $input['name'] }}" value="{{ $value }}">
                @elseif ($required)
                    <input type="hidden" name="{{ $input['name'] }}" value="-29.168039,-51.182681">
                @endif
                <div class="map form-control"></div>
                <div class="search">
                    <div class="button-clear-position {{ $required || $value? 'show' : '' }}"><i class="fa fa-eraser"></i></div>
                    <input type="text" class="input-search-position form-control" autocomplete="false" placeholder="Procurar Local">
                    <div class="button-search-position"><i class="fas fa-search"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
