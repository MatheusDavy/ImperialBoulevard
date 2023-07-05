@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $name = $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';

    $value = array();

    if($item){
        $value = is_array($item->{$input['name']}) ? $item->{$input['name']} : array();
    }
@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}">{{ $input['title'] }}</label>
        </div>
        <div class="{{ $icol }}">
            <div class="card">
                <div class="card-header multiple_checkbox">
                    @foreach (${$input['source']} as $opt)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="{{ $name }}[]" value="{{ $opt->id }}" {{ in_array($opt->id, $value) ? 'checked' : '' }}> {{ $opt->title }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
