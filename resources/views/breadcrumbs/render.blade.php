@if($breadcrumbs->count()>1)
<div class="bg-white p-2 ">

@foreach($breadcrumbs as $b)

    @if($loop->last)
        @if($b->current ) 
            {{ $b->title }}
        @else
            <a class="link"  href="{{ $b->url }}">{{ $b->title }}</a>
        @endif
    @else
        <a class="link"  href="{{ $b->url }}">{{ $b->title}}</a><span class="font-bold p-2">&gt;</span>
    @endif

@endforeach
</div>
@endif
