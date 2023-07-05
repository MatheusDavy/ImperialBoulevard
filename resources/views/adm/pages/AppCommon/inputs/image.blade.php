@php
    $half = (isset($input['half']) && $input['half']);
    $col = $half ? 'col-sm-6' : 'col-sm-12';
    $lcol = $half ? 'col-sm-4' : 'col-sm-2';
    $icol = $half ? 'col-sm-8' : 'col-sm-10';

    $resol = '';
    $width = '';
    $height = '';
    if (isset($input['imageResolution']) && $input['imageResolution']) {
        list($width, $height) = $input['imageResolution'];
        $resol = $width . "x" . $height . "x";
    }

    $name = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'].']['.$k.']' : $input['name'];
    $nameAlt = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'] . 'Alt' .']['.$k.']' : $input['name'] . 'Alt';
    $nameTitle = isset($input['multilanguage']) && $input['multilanguage'] ? 'language['.$input['name'] . 'Title' .']['.$k.']' : $input['name'] . 'Title';
    $required = isset($input['required']) && $input['required'] ? 'required' : '';

    $value = false;

    if($item) {
        $value = $item->{$input['name']};
        $imageAlt = '';
        $imageTitle = '';
        $value = decodeImageJson($value, $lang);
        $src = $value;
        if (is_object($value)) {
            if (!isset($value->src)) {
                $value->src = '';
            }
            $src = $value->src;
        }

        if (isset($value->alt)) $imageAlt = $value->alt;
        if (isset($value->title)) $imageTitle = $value->title;

        $value = $src;
        $file = $value;

        if($value){
            $value = url(config('app.userfiles_path').$input['folder'].'/'.$value);
            $thumb = resize(config('app.userfiles_path').$input['folder'].'/'.$file, 200, 200);
        }
    }
@endphp

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        <div class="{{ $lcol }}">
            <label class="col-form-label {{ $required }}"><?php echo $input['title']; ?></label>
        </div>
        <div class="{{ $icol }}">
            <div class="image-input {{ $required }} {{ $value ? 'filled' : '' }}" data-url="{{ route('adm.upload') }}" 
                data-folder="{{ $input['folder'] }}" data-name="{{ $name }}" data-nameAlt="{{ $nameAlt }}" data-nameTitle="{{ $nameTitle }}">
                <label data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{{$resol}}">
                    @if($value)
                        <img src="{{ $thumb }}" />
                    @endif
                    <i class="fas fa-image placeholder"></i>
                    <i class="fas fa-edit edit"></i>
                    <input type="file" name="file">
                </label>
                <div class="ctrls">
                    <div class="see" data-name="{{ $name }}" data-nameAlt="{{ $nameAlt }}" data-nameTitle="{{ $nameTitle }}" 
                        data-href="{{ $value }}"><i class="fas fa-eye"></i></div>
                    <div class="remove"><i class="fas fa-trash"></i></div>
                </div>
                <input class="d-none" name="resolution" height="{{$height}}" width="{{$width}}">
                @if($value)
                    <input type="hidden" name="{{ $name }}" value="{{ $file }}">
                    <input type="hidden" name="{{ $nameAlt }}" nameAttr="{{ $nameAlt }}" value="{{ $imageAlt }}">
                    <input type="hidden" name="{{ $nameTitle }}" nameAttr="{{ $nameTitle }}" value="{{ $imageTitle }}">
                @endif
            </div>
        </div>
    </div>
</div>
