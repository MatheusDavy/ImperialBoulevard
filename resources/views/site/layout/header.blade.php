@isset($languages)
<select id="changeLang" class="form-select lang">
    <option value="">{{strtoupper($languages[$language])}}</option>
    @php
        unset($languages[$language]);
    @endphp
    @foreach ($languages as $k => $l)
        <option value="{{$l}}">{{ strtoupper($l) }}</option>
    @endforeach
</select>
<header id="header">
	<p>{{lang("Header")}}</p>
</header>
@endisset ()