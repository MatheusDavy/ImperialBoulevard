<div class="row">
    @foreach($fields as $field)
        <div class="{{ isset($field['half']) && $field['half'] ? 'col-sm-6' : 'col-sm-12' }}">
            <p class="m-0"><b>{{ $field['title'] }}:</b></p>
            @if (isset($field['type']) && $field['type'] == 'image' && $item->{$field['name']})
                <img class="img-fluid" src="{{$field['src']}}" />
            @elseif (isset($field['type']) && $field['type'] == 'video' && $item->{$field['name']})
                <video width="320" height="240" controls="">
                    <source src="{{$field['src']}}" type="{{$field['mime']}}">
                    Your browser does not support the video tag.
                </video>
            @else
                <p>{{ nl2br($item->{$field['name']}) }}</p>
            @endif
        </div>
    @endforeach
</div>