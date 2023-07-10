@php
    $required = isset($input['required']) && $input['required'] ? 'required' : '';
    $itens = isset($item->{$input['name']}) ? $item->{$input['name']} : [];
    $resol = '';
    $width = '';
    $height = '';
    if (isset($input['imageResolution']) && $input['imageResolution']) {
        list($width, $height) = $input['imageResolution'];
        $resol = $width . "x" . $height . "x";
    }
@endphp
<div class="gallery-input {{ $required }} {{ $itens ? 'filled' : '' }}" data-name="{{ $input['name'] }}" data-folder="{{ $input['folder'] }}" data-url="{{ route('adm.upload') }}">
    <input class="d-none" name="resolution" height="{{$height}}" width="{{$width}}">
    <div class="top">
        <label class="btn btn-success add-images">
            <input type="file" name="file" multiple>
            <i class="fas fa-images"></i>
            <span data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="{{$resol}}">Adicionar Imagens</span>
        </label>
        <div class="btn btn-danger remove-images">
            <i class="fas fa-trash"></i>
            <span>Remover Selecionadas</span>
        </div>
    </div>
    <div class="itens">
        @foreach ($itens as $image)
        @php
            $imageAlt = '';
            $imageTitle = '';
            if (preg_match('/src/', $image->image)) {
                $json = json_decode($image->image);
                $image->image = $json->src;
                if (isset($json->alt)) {
                    $imageAlt = $json->alt;

                }
                if (isset($json->title)) {
                    $imageTitle = $json->title;
                }
            }
            $path = config('app.userfiles_path').$input['folder'].'/'.$image->image;
            $fileHref = url($path);
            $fileResize = resize($path, 200, 200, 'crop');
        @endphp
            <div class="item">
                <div class="image" style="background-image: url('{{ $fileResize }}');"
                    data-href="{{ $fileHref }}" data-name="{{ $input['name'] }}"></div>
                <input type="text" class="form-control title" name="{{ $input['name'] }}[title][]" value="{{ $image->title }}">
                <label class="checkbox"><input type="checkbox" class="gallery-checkbox"><span class="icon"></span></label>
                <div class="favorite {{ $image->highlighted == '1' ? 'on' : '' }}">
                    <input type="hidden" name="{{ $input['name'] }}[highlighted][]" value="{{ $image->highlighted == '1' ? '1' : '0' }}">
                    <div class="icon"><i class="far fa-star"></i><i class="fas fa-star"></i></div>
                </div>
                <input type="hidden" name="{{ $input['name'] }}[image][]" value="{{ $image->image }}">
                <input type="hidden" name="{{ $input['name'] }}[imageAlt][]" value="{{ $imageAlt }}">
                <input type="hidden" name="{{ $input['name'] }}[imageTitle][]" value="{{ $imageTitle }}">
            </div>
        @endforeach
    </div>
</div>
