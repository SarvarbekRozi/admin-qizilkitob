@extends('layouts.admin')

@section('title', 'Yangi blog post')
@section('page-title', 'Yangi blog post')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.blog.index') }}">Blog</a>
    <span class="sep">/</span>
    <span>Yangi</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
@csrf

<div class="page-header">
    <div class="page-header-left">
        <h1>Yangi blog post</h1>
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
        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
@endif

<div class="row g-3">

    <!-- Left -->
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
                               value="{{ old('title_'.$lang) }}" {{ $lang === 'uz' ? 'required' : '' }}>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Qisqa tavsif ({{ $langLabel }})</label>
                        <textarea name="excerpt_{{ $lang }}" class="form-control" rows="3">{{ old('excerpt_'.$lang) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kontent ({{ $langLabel }})</label>
                        <div id="editor-{{ $lang }}" style="min-height:250px;"></div>
                        <textarea name="content_{{ $lang }}" id="content-{{ $lang }}" class="d-none">{{ old('content_'.$lang) }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right -->
    <div class="col-lg-4">

        <!-- Settings -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-gear me-2"></i>Sozlamalar</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Slug (URL)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Avtomatik">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategoriya</label>
                    <select name="category_id" class="form-select">
                        <option value="">Kategoriyasiz</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->title_uz }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Teglar</label>
                    <select name="tags[]" class="form-select" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                {{ $tag->title_uz }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Muallif</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author') }}" placeholder="Muallif ismi">
                </div>
                <div class="form-group">
                    <label class="form-label">Nashr sanasi</label>
                    <input type="datetime-local" name="publish_date" class="form-control" value="{{ old('publish_date') }}">
                </div>
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px; margin-top:8px;">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label class="form-check-label" for="is_active" style="cursor:pointer; font-size:14px; font-weight:500;">
                        <i class="bi bi-eye me-1"></i> Faol
                    </label>
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-image me-2"></i>Media</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Muqova rasmi</label>
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
                    <input type="text" name="video" class="form-control" value="{{ old('video') }}" placeholder="YouTube yoki boshqa URL">
                </div>
                <div class="form-group">
                    <label class="form-label">Audio URL</label>
                    <input type="text" name="audio" class="form-control" value="{{ old('audio') }}" placeholder="Audio fayl URL">
                </div>
            </div>
        </div>

    </div>
</div>

</form>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
.ql-container { font-size: 14px; }
.ql-editor { min-height: 220px; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
const quillEditors = {};
const toolbarOptions = [
    [{ 'header': [1, 2, 3, false] }],
    ['bold', 'italic', 'underline'],
    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
    ['link', 'blockquote'],
    ['clean']
];

['uz', 'ru', 'en'].forEach(function(lang) {
    const editor = new Quill('#editor-' + lang, {
        theme: 'snow',
        modules: { toolbar: toolbarOptions }
    });
    const textarea = document.getElementById('content-' + lang);
    if (textarea.value) {
        editor.root.innerHTML = textarea.value;
    }
    quillEditors[lang] = editor;
});

document.querySelector('form').addEventListener('submit', function() {
    ['uz', 'ru', 'en'].forEach(function(lang) {
        document.getElementById('content-' + lang).value = quillEditors[lang].root.innerHTML;
    });
});

function switchLang(lang, btn) {
    document.querySelectorAll('.lang-panel').forEach(p => p.style.display = 'none');
    document.querySelectorAll('.lang-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('lang-' + lang).style.display = 'block';
    btn.classList.add('active');
}
</script>
@endpush
