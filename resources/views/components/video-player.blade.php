@props(['news'])

@php
    $hasLocalVideo = $news->video_type === 'local'
        && $news->video_url
        && \Illuminate\Support\Facades\Storage::disk('public')->exists($news->video_url);
    $hasYoutubeVideo = $news->video_type === 'youtube' && $news->video_url;
@endphp

@if ($hasLocalVideo)
    <video class="w-100 border-gaming" controls>
        <source src="{{ asset('storage/'.$news->video_url) }}">
    </video>
@elseif ($hasYoutubeVideo)
    <div class="ratio ratio-16x9 border-gaming">
        <iframe src="https://www.youtube.com/embed/{{ $news->video_url }}" title="{{ $news->title }}" allowfullscreen></iframe>
    </div>
@endif
