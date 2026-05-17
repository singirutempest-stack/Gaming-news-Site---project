@props(['item'])

<article class="card h-100">
    @if($item->image)
        <img class="card-img-top" src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->localizedTitle() }}">
    @else
        <div class="card-img-top d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#12121a 0%,{{ $item->category->color ?? '#7b2fff' }}55 100%)">
            <i class="bi bi-controller" style="font-size:3rem;color:{{ $item->category->color ?? '#7b2fff' }};opacity:0.7"></i>
        </div>
    @endif
    <div class="card-body d-flex flex-column gap-2">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <span class="badge" style="background: {{ $item->category->color }}">{{ $item->category->label() }}</span>
            <span class="small text-muted">{{ $item->published_at?->format('M d, Y') }}</span>
        </div>
        <h3 class="h5 mb-0"><a href="{{ route('news.show', $item) }}">{{ $item->localizedTitle() }}</a></h3>
        <p class="text-muted mb-0">{{ $item->localizedShortDescription() }}</p>
        <div class="mt-auto small text-muted d-flex justify-content-between">
            <span>{{ $item->author->name ?? 'Portal' }}</span>
            <span><i class="bi bi-eye"></i> {{ number_format($item->views) }}</span>
        </div>
    </div>
</article>
