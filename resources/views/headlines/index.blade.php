 
<ul class="none">
    @foreach ($headlines as $item)
        <li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
    @endforeach
</ul>
