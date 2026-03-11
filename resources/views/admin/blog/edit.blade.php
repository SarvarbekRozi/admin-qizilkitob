@extends('layouts.admin')

@section('title', 'Blog postni tahrirlash')
@section('page-title', 'Blog postni tahrirlash')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.blog.index') }}">Blog</a>
    <span class="sep">/</span>
    <span>Tahrirlash</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.blog.update', $blog) }}" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="page-header">
    <div class="page-header-left">
        <h1>{{ Str::limit($blog->title_uz, 50) }}</h1>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.blog.index') }}" class="btn-secondary-custom">
            <i class="bi bi-arrow-left"></i> Orqaga
        </a>
        <button type="submit" class="btn-primary-custom">
            <i class="bi bi-check-lg"></i> Saqlash
        </button>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>@foreach($errors->all() as $err) <div>{{ $err }}</div> @endforeach</div>
    </div>
@endif

<div class="row g-3">

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-translate me-2"></i>Kontent</h6>
            </div>
            <div class="card-body">
                <div class="lang-tabs">
                    <button type="button" class="lang-tab active" onclick="switchLang('uz', this)">🇺🇿 O'zbek</button>
                    <button type="button" class="lang-tab" onclick="switchLang('ru', this)">🇷🇺 Русский</button>
                    <button type="button" class="lang-tab" onclick="switchLang('en', this)">🇬🇧 English</button>
                </div>

                @foreach(['uz' => "O'zbek", 'ru' => 'Rus', 'en' => 'Ingliz'] as $lang => $langLabel)
                <div id="lang-{{ $lang }}" class="lang-panel" style="{{ $lang !== 'uz' ? 'display:none;' : '' }}">
                    <div class="form-group">
                        <label class="form-label">Sarlavha ({{ $langLabel }}) *</label>
                        <input type="text" name="title_{{ $lang }}" class="form-control"
                               value="{{ old('title_'.$lang, $blog->{'title_'.$lang}) }}"
                               {{ $lang === 'uz' ? 'required' : '' }}>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Qisqa tavsif ({{ $langLabel }})</label>
                        <textarea name="excerpt_{{ $lang }}" class="form-control" rows="3">{{ old('excerpt_'.$lang, $blog->{'excerpt_'.$lang}) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kontent ({{ $langLabel }})</label>
                        <textarea name="content_{{ $lang }}" class="form-control" rows="10">{{ old('content_'.$lang, $blog->{'content_'.$lang}) }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-4">

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-gear me-2"></i>Sozlamalar</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $blog->slug) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategoriya</label>
                    <select name="category_id" class="form-select">
                        <option value="">Kategoriyasiz</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $blog->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->title_uz }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Teglar</label>
                    <select name="tags[]" class="form-select" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', $blog->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $tag->title_uz }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Muallif</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author', $blog->author) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Nashr sanasi</label>
                    <input type="datetime-local" name="publish_date" class="form-control"
                           value="{{ old('publish_date', $blog->publish_date?->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px; margin-top:8px;">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $blog->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active" style="cursor:pointer; font-size:14px; font-weight:500;">
                        <i class="bi bi-eye me-1"></i> Faol
                    </label>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-image me-2"></i>Media</h6>
            </div>
            <div class="card-body">
                @if($blog->image)
                    <div style="margin-bottom:12px;">
                        <img src="{{ $blog->image }}" alt="" style="width:100%; border-radius:8px; border:1px solid var(--border);">
                    </div>
                @endif
                <div class="form-group">
                    <label class="form-label">{{ $blog->image ? 'Yangi rasm' : 'Muqova rasmi' }}</label>
                    <div class="img-upload-area" onclick="document.getElementById('blog_image').click()">
                        <input type="file" id="blog_image" name="image" accept="image/*"
                               onchange="previewImage(this, 'preview_blog')">
                        <div class="img-upload-icon">📷</div>
                        <div class="img-upload-text">Rasm yuklash</div>
                        <div class="img-upload-hint">PNG, JPG, WEBP &bull; Max 5MB</div>
                    </div>
                    <img id="preview_blog" src="" alt="" class="img-preview" style="display:none;">
                </div>
                <div class="form-group">
                    <label class="form-label">Video URL</label>
                    <input type="text" name="video" class="form-control" value="{{ old('video', $blog->video) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Audio URL</label>
                    <input type="text" name="audio" class="form-control" value="{{ old('audio', $blog->audio) }}">
                </div>
            </div>
        </div>

    </div>
</div>

</form>
@endsection

@push('scripts')
<script>
function switchLang(lang, btn) {
    document.querySelectorAll('.lang-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.lang-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('lang-' + lang).style.display = 'block';
    btn.classList.add('active');
}
</script>
@endpush
