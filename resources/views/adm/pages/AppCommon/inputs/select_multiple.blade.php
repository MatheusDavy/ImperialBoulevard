@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $name = $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';
    $disabled = isset($input['disabled']) && $input['disabled'] ? 'disabled' : '';
    $source = isset(${$input['source']}) ? ${$input['source']} : array();

    $value = array();

    if($item){
        $value = (array) $item->{$input['name']};
    }
@endphp
<style>
    .select2-container {
        width: 100% !important;
    }
</style>

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}">{{ $input['title'] }}</label>
        </div>
        <div class="{{ $icol }}">
            <select name="{{ $name }}[]" class="form-control {{ $required }} select-multiple" {!! $disabled !!} multiple>
                <option value="">&nbsp;</option>
                @foreach ($source as $opt)
                    <option value="{{ $opt->id }}" {{ in_array($opt->id, $value) ? 'selected' : '' }} {{ isset($opt->disabled) ? $opt->disabled : '' }}>{!! strip_tags($opt->title) !!}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
