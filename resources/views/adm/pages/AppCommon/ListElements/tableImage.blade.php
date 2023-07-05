@php
    $imageSrc = decodeImageJson($item->{$field['name']}, null, true);
    $path = config('app.userfiles_path') . $field['folder'];
    $image = resize($path . '/' . $imageSrc, 100, 100);
@endphp
<img class="table-image" src="{{$image}}" />