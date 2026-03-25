@extends('layouts.admin')

@section('title', 'Yangi tabiiy boylik')
@section('page-title', 'Yangi tabiiy boylik')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.natural-resources.index') }}">Tabiiy boyliklar</a>
    <span class="sep">/</span>
    <span>Yangi</span>
@endsection

@section('content')

<form id="main-form" method="POST" action="{{ route('admin.natural-resources.store') }}" enctype="multipart/form-data">
@csrf

<div class="page-header">
    <div class="page-header-left">
        <h1>Yangi tabiiy boylik</h1>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.natural-resources.index') }}" class="btn-secondary-custom">
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

        <!-- Content Tabs -->
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
                        <label class="form-label">Sarlavha ({{ $langLabel }}) @if($lang === 'uz') <span class="req-badge">Majburiy</span> @endif</label>
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
                    <div class="form-group">
                        <label class="form-label">Xususiyatlar ({{ $langLabel }})</label>
                        <textarea name="features_{{ $lang }}" class="form-control" rows="4" placeholder="Har qatorda bir xususiyat...">{{ old('features_'.$lang) }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Stats & Location -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-bar-chart me-2"></i>Statistika va joylashuv</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Maydoni</label>
                            <input type="text" name="stat_area" class="form-control" value="{{ old('stat_area') }}" placeholder="5000 ga">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Turlar soni</label>
                            <input type="text" name="stat_species" class="form-control" value="{{ old('stat_species') }}" placeholder="150+">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Muhofaza darajasi</label>
                            <input type="text" name="stat_protected" class="form-control" value="{{ old('stat_protected') }}" placeholder="I daraja">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Kenglik (Latitude)</label>
                            <input type="number" name="latitude" class="form-control" step="0.0000001" value="{{ old('latitude') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Uzunlik (Longitude)</label>
                            <input type="number" name="longitude" class="form-control" step="0.0000001" value="{{ old('longitude') }}">
                        </div>
                    </div>
                </div>
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
                    <label class="form-label">Slug (URL)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Avtomatik">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategoriya (Muhofaza hududi)</label>
                    <select name="category" class="form-select">
                        <option value="">— Tanlang —</option>
                        @foreach($protectedAreas as $area)
                            <option value="{{ $area->slug }}"
                                {{ old('category') === $area->slug ? 'selected' : '' }}>
                                {{ $area->name_uz }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px; margin-bottom:10px;">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label class="form-check-label" for="is_active" style="cursor:pointer; font-size:14px; font-weight:500;">
                        <i class="bi bi-eye me-1"></i> Faol
                    </label>
                </div>
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px;">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1">
                    <label class="form-check-label" for="featured" style="cursor:pointer; font-size:14px; font-weight:500;">
                        <i class="bi bi-star me-1" style="color:var(--secondary-dark);"></i> Featured
                    </label>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-image me-2"></i>Asosiy rasm</h6>
            </div>
            <div class="card-body">
                <div class="img-upload-area">
                    <input type="file" id="res_image" name="image" accept="image/*"
                           onchange="previewImage(this, 'preview_res', 5)">
                    <div class="img-upload-icon">📷</div>
                    <div class="img-upload-text">Rasm yuklash</div>
                    <div class="img-upload-hint">PNG, JPG, WEBP &bull; Max 5MB</div>
                </div>
                <img id="preview_res" src="" alt="" class="img-preview" style="display:none;">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-images me-2"></i>Galereya</h6>
            </div>
            <div class="card-body">
                <div class="img-upload-area">
                    <input type="file" name="image_gallery[]" accept="image/*" multiple onchange="previewGallery(this)">
                    <div class="img-upload-icon">🖼️</div>
                    <div class="img-upload-text">Galereya rasmlari</div>
                    <div class="img-upload-hint">Bir nechta tanlash mumkin</div>
                </div>
                <div id="gallery-preview" class="gallery-grid"></div>
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

document.getElementById('main-form').addEventListener('submit', function() {
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

function previewGallery(input) {
    const grid = document.getElementById('gallery-preview');
    grid.innerHTML = '';
    const maxMB = 5;
    const oversize = [];
    Array.from(input.files).forEach(file => {
        const sizeMB = file.size / (1024 * 1024);
        if (sizeMB > maxMB) { oversize.push(file.name + ' (' + sizeMB.toFixed(1) + 'MB)'); return; }
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'gallery-item';
            div.innerHTML = '<img src="' + e.target.result + '">';
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    const oldErr = document.getElementById('gallery_err');
    if (oldErr) oldErr.remove();
    if (oversize.length) {
        input.value = '';
        grid.innerHTML = '';
        const err = document.createElement('div');
        err.id = 'gallery_err';
        err.className = 'alert alert-danger mt-2 py-2';
        err.style.fontSize = '13px';
        err.textContent = 'Quyidagi rasmlar ' + maxMB + 'MB dan katta: ' + oversize.join(', ');
        input.closest('.card-body').appendChild(err);
    }
}
</script>
@endpush
