 

@php
    $items = app(\App\Services\PagelineService::class)->showNewPosts();
@endphp

<ul>
    @foreach ($items as $item)
        <li>

            <a href="{{ $item['url'] }}">
                {{ $item['title'] }}
            </a>
        </li>
    @endforeach
</ul>