@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $name = $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';
    $source = isset($input['source']) ? ${$input['source']}: [];

    $value = array();
    $values = [];
    if($item){
        $value = $item->{$input['name']};
        $values = explode(',', $value);
    }
@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}">{{ $input['title'] }}</label>
        </div>
        <div class="{{ $icol }}">
            <div class="card">
                <select name="{{ $name }}[]" class="form-control js-example-tokenizer" multiple="multiple">
                    @if ($values)
                        @foreach ($values as $value)
                            @if (modelTranslate($value, $lang))
                                <option selected="selected">{{ modelTranslate($value, $lang) }}</option>
                            @endif
                        @endforeach
                    @endif
                    @if ($source)
                        @foreach ($source as $key => $option)
                            @if (!in_array($option, $values))
                                <option>{{ modelTranslate($option, $lang) }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
</div>
