@extends('layouts.admin')

@section('title', 'Tabiiy boylikni tahrirlash')
@section('page-title', 'Tabiiy boylikni tahrirlash')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.natural-resources.index') }}">Tabiiy boyliklar</a>
    <span class="sep">/</span>
    <span>Tahrirlash</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.natural-resources.update', $naturalResource) }}" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="page-header">
    <div class="page-header-left">
        <h1>{{ Str::limit($naturalResource->title_uz, 50) }}</h1>
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
                               value="{{ old('title_'.$lang, $naturalResource->{'title_'.$lang}) }}"
                               {{ $lang === 'uz' ? 'required' : '' }}>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Qisqa tavsif ({{ $langLabel }})</label>
                        <textarea name="excerpt_{{ $lang }}" class="form-control" rows="3">{{ old('excerpt_'.$lang, $naturalResource->{'excerpt_'.$lang}) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kontent ({{ $langLabel }})</label>
                        <div id="editor-{{ $lang }}" style="min-height:250px;"></div>
                        <textarea name="content_{{ $lang }}" id="content-{{ $lang }}" class="d-none">{{ old('content_'.$lang, $naturalResource->{'content_'.$lang}) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Xususiyatlar ({{ $langLabel }})</label>
                        <textarea name="features_{{ $lang }}" class="form-control" rows="4">{{ old('features_'.$lang, is_array($naturalResource->{'features_'.$lang}) ? implode("\n", $naturalResource->{'features_'.$lang}) : '') }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-bar-chart me-2"></i>Statistika va joylashuv</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Maydoni</label>
                            <input type="text" name="stat_area" class="form-control" value="{{ old('stat_area', $naturalResource->stat_area) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Turlar soni</label>
                            <input type="text" name="stat_species" class="form-control" value="{{ old('stat_species', $naturalResource->stat_species) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Muhofaza darajasi</label>
                            <input type="text" name="stat_protected" class="form-control" value="{{ old('stat_protected', $naturalResource->stat_protected) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Kenglik</label>
                            <input type="number" name="latitude" class="form-control" step="0.0000001" value="{{ old('latitude', $naturalResource->latitude) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Uzunlik</label>
                            <input type="number" name="longitude" class="form-control" step="0.0000001" value="{{ old('longitude', $naturalResource->longitude) }}">
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
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $naturalResource->slug) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategoriya (Muhofaza hududi)</label>
                    <select name="category" class="form-select">
                        <option value="">— Tanlang —</option>
                        @foreach($protectedAreas as $area)
                            <option value="{{ $area->slug }}"
                                {{ old('category', $naturalResource->category) === $area->slug ? 'selected' : '' }}>
                                {{ $area->name_uz }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px; margin-bottom:10px;">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $naturalResource->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active" style="cursor:pointer; font-size:14px; font-weight:500;">
                        <i class="bi bi-eye me-1"></i> Faol
                    </label>
                </div>
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px;">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1"
                           {{ old('featured', $naturalResource->featured) ? 'checked' : '' }}>
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
                @if($naturalResource->image)
                    <div style="margin-bottom:12px;">
                        <img src="{{ $naturalResource->image }}" alt="" style="width:100%; border-radius:8px; border:1px solid var(--border);">
                    </div>
                @endif
                <div class="img-upload-area">
                    <input type="file" id="res_image" name="image" accept="image/*"
                           onchange="previewImage(this, 'preview_res', 5)">
                    <div class="img-upload-icon">📷</div>
                    <div class="img-upload-text">{{ $naturalResource->image ? 'Yangi rasm' : 'Rasm yuklash' }}</div>
                    <div class="img-upload-hint">PNG, JPG &bull; Max 5MB</div>
                </div>
                <img id="preview_res" src="" alt="" class="img-preview" style="display:none;">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-images me-2"></i>Galereya</h6>
            </div>
            <div class="card-body">
                @if(!empty($naturalResource->image_gallery))
                    <div class="gallery-grid mb-3">
                        @foreach($naturalResource->image_gallery as $img)
                            <div class="gallery-item" id="gal-{{ md5($img) }}">
                                <img src="{{ $img }}" alt="">
                                <button type="button" class="remove-btn" onclick="removeGal('{{ $img }}', 'gal-{{ md5($img) }}')">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div id="gal-remove-inputs"></div>
                @endif
                <div class="img-upload-area">
                    <input type="file" name="image_gallery[]" accept="image/*" multiple>
                    <div class="img-upload-icon">🖼️</div>
                    <div class="img-upload-text">Yangi rasmlar qo'shish</div>
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

function removeGal(img, id) {
    document.getElementById(id)?.remove();
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'gallery_remove[]';
    input.value = img;
    document.getElementById('gal-remove-inputs')?.appendChild(input);
}
</script>
@endpush
