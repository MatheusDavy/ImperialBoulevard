@php
    $half = (isset($input['half']) && $input['half']);
    $col = 'col-sm-12';
    $lcol = 'col-sm-2';
    $icol = 'col-sm-2 pb-3';

    $folder = '';

    $resol = '';
    $width = '';
    $height = '';
    if (isset($input['imageResolution']) && $input['imageResolution']) {
        list($width, $height) = $input['imageResolution'];
        $resol = $width . "x" . $height . "x";
    }

    $required = isset($input['required']) && $input['required'] ? 'required' : '';

    $value = false;
    // data-toggle="tooltip" data-placement="top" title="" data-original-title="Adicionar"
@endphp
<style>
    .image-input label {
        width: 10vw;
        height: 21vh;
    }
    .see-save {
        display: inline-block;
        vertical-align: middle;
        width: 25px;
        height: 25px;
        background: var(--primary);
        border-radius: 3px;
        text-align: center;
        color: #fff;
        position: relative;
        cursor: pointer;
        background-color: cadetblue;
    }
    .save-icon {
        font-size: 15px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        vertical-align: middle;
    }
</style>

<div class="form-group {{ $col }} mb-4">
    <div class="row column">
        @foreach ($itens as $key => $item)
        @if (isset($item->title))
            @php
                if ($item) {
                    $folder = $item->folder;
                    $value = isset($input['multilanguage']) && $input['multilanguage'] ? $item->language[$k]->{$input['name']} : $item->title;
                    $table = encrypt($item->table);
                    $foreignKey = encrypt($item->foreignKey);
                    if (preg_match('/src/', $value)) {
                        $value = json_decode($value);
                        $src = $value->src;
                        $imageAlt = '';
                        $imageTitle = '';
                        if (isset($value->alt)) {
                            $imageAlt = $value->alt;

                        }
                        if (isset($value->title)) {
                            $imageTitle = $value->title;
                        }
                    }
                    $value = $src;
                    $file = $value;
                    if($value){
                        $value = url(config('app.userfiles_path').$folder.'/'.$value);
                        $thumb = resize(config('app.userfiles_path').$folder.'/'.$file, 200, 200);
                    }

                }
            @endphp
            <div class="{{ $icol }}">
                <div class="image-input {{ $required }} {{ $value ? 'filled' : '' }}" data-url="{{ route('adm.upload') }}" data-folder="{{ $folder }}" data-name="{{ $item->column }}">
                    <label data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$resol}}">
                        @if($value)
                            <img src="{{ $thumb }}" />
                        @endif
                        <i class="fas fa-image placeholder"></i>
                        <i class="fas fa-edit edit"></i>
                        <input type="file" name="file">
                    </label>
                    <div class="ctrls" style="margin-left: 0px">
                        <div class="see" data-href="{{ $value }}"><i class="fas fa-eye"></i></div>

                        <div class="see-save"
                            data-id="{{$item->moduleId}}"
                            action="{{ $action }}"
                            data-table="{{$table}}"
                            data-value="{{ $item->title }}"
                            data-folder="{{ $folder }}"
                            data-name="{{ $item->column }}"
                            data-gallery="{{ $item->isGallery }}"
                            data-foreign="{{ $foreignKey }}"
                            data-lang="{{ $item->isLang }}"
                            data-language="{{ $item->language }}"
                            name="generalGallerySave"
                        >
                            <i class="far fa-save save-icon"></i>
                        </div>
                        @if ($item->isGallery)
                            <div class="badge badge-light" style="display: flex;position: absolute;bottom: 25vh;z-index: 2;">
                                @php
                                    $titleBadge = character_limiter("$item->module - $item->moduleId (Galeria)", 25)
                                @endphp
                                {{$titleBadge}}
                            </div>
                        @elseif ($item->isLang == 1)
                            <div class="badge badge-light" style="display: flex;position: absolute;bottom: 25vh;z-index: 2;">
                                @php
                                    $language[1] = 'Pt-Br';
                                    $language[2] = 'En';
                                    $language[3] = 'Es';
                                    $lang = $language[intval($item->language)];
                                    $titleBadge = character_limiter("$item->module - $item->moduleId - $lang", 25);
                                @endphp
                                {{$titleBadge}}
                            </div>
                        @else
                            <div class="badge badge-light" style="display: flex;position: absolute;bottom: 25vh;z-index: 2;">
                                @php
                                    $titleBadge = character_limiter("$item->module - $item->moduleId", 25)
                                @endphp
                                {{$titleBadge}}
                            </div>
                        @endif
                        <div class="remove"><i class="fas fa-trash"></i></div>
                    </div>
                    {{-- <input type="hidden" name="resolution" height="{{$height}}" width="{{$width}}"> --}}
                    @if($value)
                        <input type="hidden" name="{{ $item->column }}" value="{{ $file }}">
                        <input type="hidden" name="{{ $item->column }}Src" value="{{ $imageAlt }}">
                    <input type="hidden" name="{{ $item->column }}Title" value="{{ $imageTitle }}">
                    @endif
                </div>
            </div>
        @endif
        @endforeach
    </div>
</div>
