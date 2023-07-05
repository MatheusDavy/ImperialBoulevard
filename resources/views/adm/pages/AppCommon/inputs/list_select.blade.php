@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';
    $plugin = (isset($input['plugin']) && $input['plugin']);

    $name = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'].']['.$k.']' : $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';

    $source = isset(${$input['source']}) ? ${$input['source']} : array();

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
            <select name="{{ $name }}" class="form-control {{ $required }} {{ $plugin ? 'select-plugin' : ''}}">
                <option value="">&nbsp;</option>
                @foreach ($source as $opt)
                    <option value="{{ $opt->id }}" {{ $opt->id == $value ? 'selected' : '' }}>{{ {{ modelTranslate($opt->title, $lang) }} }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$('#addRelated').click(function() {
    let data = `
    <div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}">{{ $input['title'] }}</label>
        </div>
        <div class="{{ $icol }}">
            <select name="{{ $name }}" class="form-control {{ $required }} {{ $plugin ? 'select-plugin' : ''}}">
                <option value="">&nbsp;</option>
                @foreach ($source as $opt)
                    <option value="{{ $opt->id }}" {{ $opt->id == $value ? 'selected' : '' }}>{{ $opt->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>`
    $('#relatedFormGroup').append(data);
});
</script>
