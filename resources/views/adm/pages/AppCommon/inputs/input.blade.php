@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $name = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'].']['.$k.']' : $input['name'];
    $required = isset($input['required']) && $input['required'] ? 'required' : '';
    $class = isset($input['class']) && $input['class'] ? $input['class'] : '';
    $mask = isset($input['mask']) && $input['mask'] ? $input['mask'] : '';
    $admin = isset($input['admin']) && $input['admin'] ? true : '';

    if (isset($user) && $user && $admin) {
        if ($user->id_group !== 1) {
            $admin = 'disabled';
        }
    }

    $value = '';
    $tooltip = '';
    if (isset($input['tooltip'])) {
        $tooltip = $input['tooltip'];
    }
    $type = 'text';
    if (isset($input['password']) && $input['password']) {
        $type = 'password';
    }

    if($item){
        $value = $item->{$input['name']};
    }
@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}"><?php echo $input['title']; ?></label>
        </div>
        <div class="{{ $icol }}" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{{$tooltip}}">
            <input type="{{$type}}" {{$admin}} class="form-control {{ $required }} {{ $class }} {{ $mask ? 'input-mask' : '' }}" name="{{ $name }}" type="text" value="{{ modelTranslate($value, $lang) }}"  <?php echo $mask ? 'data-mask="'.$mask.'"' : ''; ?>>
        </div>
    </div>
</div>
