@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $name = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'].']['.$k.']' : $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';

    $value = '';

    if($item){
        $value = $item->{$input['name']};
    }
@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}"><?php echo $input['title']; ?></label>
        </div>
        <div class="{{ $icol }}">
            <textarea rows="4" class="form-control {{ $required }}" name="{{ $name }}">{{ modelTranslate($value, $lang) }}</textarea>
        </div>
    </div>
</div>