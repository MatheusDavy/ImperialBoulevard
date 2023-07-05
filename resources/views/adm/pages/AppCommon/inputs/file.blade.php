@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $name = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'].']['.$k.']' : $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';

    $value = false;

    if($item){
        $value = $item->{$input['name']};
        $value = modelTranslate($value, $lang);
    }
@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}">{{ $input['title'] }}</label>
        </div>
        <div class="{{ $icol }}">
            <div class="file-input {{ $required }} {{ $value ? 'filled' : '' }}" data-url="{{ route('adm.upload') }}" data-folder="{{ $input['folder'] }}" data-name="{{ $name }}">
                <label class="form-control">
                    <i class="fas fa-file-alt placeholder"></i>
                    <span>{{ $value ? $value : '' }}</span>
                    <input type="file" name="file">
                </label>
                <div class="ctrls">
                    <a class="see" href="{{ $value ? url(config('app.userfiles_path').$input['folder'].'/'.$value) : '' }}" target="_blank"><i class="fas fa-eye"></i></a>
                    <div class="remove"><i class="fas fa-trash"></i></div>
                </div>
                @if($value)
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                @endif
            </div>
        </div>
    </div>
</div>