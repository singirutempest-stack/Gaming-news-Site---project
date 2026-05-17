@extends($mode === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('title', $mode === 'create' ? __('app.add_news') : __('app.edit_news'))

@section('content')
@php
    $isAdminMode = $mode === 'admin';
    $action = $mode === 'create' ? route('news.store') : ($isAdminMode ? route('admin.news.update', $news->id) : route('news.update', $news));
@endphp
<div class="{{ $isAdminMode ? '' : 'container' }}">
    <h1>{{ $mode === 'create' ? __('app.add_news') : __('app.edit_news') }}</h1>
    <form method="post" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @if ($mode !== 'create') @method('PUT') @endif
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="bg-surface border-gaming p-3">
                    <label class="form-label">{{ __('app.title') }}</label>
                    <input class="form-control mb-3" name="title" value="{{ old('title', $news->title) }}" required>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('app.category') }}</label>
                            <select class="form-select mb-3" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $news->category_id) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('app.language') }}</label>
                            <select class="form-select mb-3" name="language">
                                @foreach (['en' => 'EN', 'ru' => 'RU', 'kz' => 'KZ'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('language', $news->language) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <label class="form-label">{{ __('app.short_description') }}</label>
                    <textarea class="form-control mb-3" name="short_description" maxlength="300" rows="3" required>{{ old('short_description', $news->short_description) }}</textarea>
                    <label class="form-label">{{ __('app.content') }}</label>
                    <textarea class="form-control mb-3" name="content" rows="12" required>{{ old('content', $news->content) }}</textarea>

                    <div class="bg-card border-gaming p-3 mb-3">
                        <h2 class="h4">{{ __('app.translations') }}</h2>
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            @foreach (['en' => 'EN', 'ru' => 'RU', 'kz' => 'KZ'] as $locale => $label)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#translation-{{ $locale }}" type="button" role="tab">{{ $label }}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach (['en' => 'EN', 'ru' => 'RU', 'kz' => 'KZ'] as $locale => $label)
                                @php($translation = $news->exists ? $news->translations->firstWhere('locale', $locale) : null)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="translation-{{ $locale }}" role="tabpanel">
                                    <label class="form-label">{{ __('app.translated_title') }} {{ $label }}</label>
                                    <input class="form-control mb-3" type="text" name="translations[{{ $locale }}][title]" value="{{ old('translations.'.$locale.'.title', $translation?->translated_title) }}">
                                    <label class="form-label">{{ __('app.translated_short_description') }} {{ $label }}</label>
                                    <textarea class="form-control mb-3" name="translations[{{ $locale }}][short_description]" maxlength="300" rows="3">{{ old('translations.'.$locale.'.short_description', $translation?->translated_short_description) }}</textarea>
                                    <label class="form-label">{{ __('app.translated_content') }} {{ $label }}</label>
                                    <textarea class="form-control mb-3" name="translations[{{ $locale }}][content]" rows="8">{{ old('translations.'.$locale.'.content', $translation?->translated_content) }}</textarea>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('app.published_at') }}</label>
                            <input class="form-control mb-3" type="date" name="published_at" value="{{ old('published_at', optional($news->published_at)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('app.views') }}</label>
                            <input class="form-control mb-3" type="number" min="0" name="views" value="{{ old('views', $news->views ?? 0) }}" @unless(auth()->user()?->isAdmin()) readonly @endunless>
                        </div>
                    </div>

                    <label class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="featured" value="1" @checked(old('featured', $news->featured))> {{ __('app.featured') }}
                    </label>

                    <label class="form-label">{{ __('app.video_type') }}</label>
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        @foreach (['none' => 'None', 'local' => 'Local Upload', 'youtube' => 'YouTube URL'] as $value => $label)
                            <label class="form-check"><input class="form-check-input video-type" type="radio" name="video_type" value="{{ $value }}" @checked(old('video_type', $news->video_type ?: 'none') === $value)> {{ $label }}</label>
                        @endforeach
                    </div>
                    <div id="youtubeField">
                        <input class="form-control mb-3" type="text" name="video_url" value="{{ old('video_url', $news->video_type === 'youtube' ? $news->video_url : '') }}" placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <div id="localField">
                        <input class="form-control mb-3" type="file" name="video_file" accept="video/mp4,video/webm">
                    </div>

                    <label class="form-label">{{ __('app.image') }}</label>
                    <input class="form-control mb-3" type="file" name="image" accept="image/jpeg,image/png" @required($mode === 'create')>
                    <label class="form-label">{{ __('app.status') }}</label>
                    <select class="form-select mb-3" name="status">
                        <option value="draft" @selected(old('status', $news->status) === 'draft')>{{ __('app.draft') }}</option>
                        <option value="published" @selected(old('status', $news->status) === 'published')>{{ __('app.published') }}</option>
                    </select>

                    <button class="btn btn-secondary" name="status" value="draft">{{ __('app.save_draft') }}</button>
                    <button class="btn btn-primary" name="status" value="published">{{ __('app.publish') }}</button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top" src="{{ $news->image ? asset('storage/'.$news->image) : asset('images/placeholder.svg') }}" alt="">
                    <div class="card-body">
                        <span class="badge bg-secondary">{{ __('app.preview') }}</span>
                        <h2 class="h4 mt-2">{{ old('title', $news->title ?: __('app.title')) }}</h2>
                        <p class="text-muted">{{ old('short_description', $news->short_description ?: __('app.short_description')) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
function syncVideoFields() {
  const value = document.querySelector('input[name="video_type"]:checked')?.value || 'none';
  document.getElementById('youtubeField').style.display = value === 'youtube' ? 'block' : 'none';
  document.getElementById('localField').style.display = value === 'local' ? 'block' : 'none';
}
document.querySelectorAll('.video-type').forEach((item) => item.addEventListener('change', syncVideoFields));
syncVideoFields();
</script>
@endsection
