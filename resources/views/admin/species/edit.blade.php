@extends('layouts.admin')

@section('title', 'Turni tahrirlash')
@section('page-title', 'Turni tahrirlash')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.species.index') }}">Turlar</a>
    <span class="sep">/</span>
    <span>Tahrirlash</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.species.update', $species) }}" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="page-header">
    <div class="page-header-left">
        <h1>{{ $species->name_uz }}</h1>
        <p class="subtitle" style="font-style:italic;">{{ $species->scientific_name }}</p>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.species.index') }}" class="btn-secondary-custom">
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
            <strong>Xatoliklar mavjud:</strong>
            <ul style="margin:4px 0 0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="row g-3">

    <!-- Left -->
    <div class="col-lg-8">

        <!-- Basic Info -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-info-circle me-2"></i>Asosiy ma'lumotlar</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Ilmiy nom <span class="req-badge">Majburiy</span></label>
                            <input type="text" name="scientific_name" class="form-control" value="{{ old('scientific_name', $species->scientific_name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $species->slug) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Kategoriya <span class="req-badge">Majburiy</span></label>
                            <select name="category" class="form-select" required>
                                <option value="animal" {{ old('category', $species->category) === 'animal' ? 'selected' : '' }}>🦊 Hayvon</option>
                                <option value="plant" {{ old('category', $species->category) === 'plant' ? 'selected' : '' }}>🌱 O'simlik</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Xavf darajasi <span class="req-badge">Majburiy</span></label>
                            <select name="danger_level" class="form-select" required>
                                <option value="critically_endangered" {{ old('danger_level', $species->danger_level) === 'critically_endangered' ? 'selected' : '' }}>CR - Juda xavfli</option>
                                <option value="endangered" {{ old('danger_level', $species->danger_level) === 'endangered' ? 'selected' : '' }}>EN - Xavfli</option>
                                <option value="vulnerable" {{ old('danger_level', $species->danger_level) === 'vulnerable' ? 'selected' : '' }}>VU - Zaif</option>
                                <option value="near_threatened" {{ old('danger_level', $species->danger_level) === 'near_threatened' ? 'selected' : '' }}>NT - Deyarli tahdid</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multilingual -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-translate me-2"></i>Ko'p tilli ma'lumotlar</h6>
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
                        <label class="form-label">
                            Nomi ({{ $langLabel }})
                            @if($lang === 'uz') <span class="req-badge">Majburiy</span> @endif
                        </label>
                        <input type="text" name="name_{{ $lang }}" class="form-control" value="{{ old('name_'.$lang, $species->{'name_'.$lang}) }}" {{ $lang === 'uz' ? 'required' : '' }}>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Qisqa tavsif ({{ $langLabel }})</label>
                        <textarea name="description_short_{{ $lang }}" class="form-control" rows="3">{{ old('description_short_'.$lang, $species->{'description_short_'.$lang}) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">To'liq tavsif ({{ $langLabel }})</label>
                        <textarea name="description_full_{{ $lang }}" class="form-control" rows="6">{{ old('description_full_'.$lang, $species->{'description_full_'.$lang}) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tavsif punktlari ({{ $langLabel }})</label>
                        <textarea name="description_bullets_{{ $lang }}" class="form-control" rows="4">{{ old('description_bullets_'.$lang, is_array($species->{'description_bullets_'.$lang}) ? implode("\n", $species->{'description_bullets_'.$lang}) : '') }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Stats -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-bar-chart me-2"></i>Statistika</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach([
                        'stat_mass' => 'Og\'irligi',
                        'stat_speed' => 'Tezligi',
                        'stat_lifespan' => 'Umri',
                        'stat_diet' => 'Oziqlanish',
                        'stat_height' => 'Balandligi',
                        'stat_bloom_period' => 'Gullash davri',
                        'stat_habitat' => 'Yashash muhiti',
                    ] as $field => $label)
                    <div class="{{ $field === 'stat_habitat' ? 'col-12' : 'col-md-6' }}">
                        <div class="form-group">
                            <label class="form-label">{{ $label }}</label>
                            <input type="text" name="{{ $field }}" class="form-control" value="{{ old($field, $species->$field) }}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Habitat -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-geo-alt me-2"></i>Yashash joyi</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach(['uz' => "O'zbek", 'ru' => 'Rus', 'en' => 'Ingliz'] as $lang => $label)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Joylashuv ({{ $label }})</label>
                            <input type="text" name="habitat_location_{{ $lang }}" class="form-control"
                                   value="{{ old('habitat_location_'.$lang, $species->{'habitat_location_'.$lang}) }}">
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Kenglik (Latitude)</label>
                            <input type="number" name="latitude" class="form-control" step="0.0000001"
                                   value="{{ old('latitude', $species->latitude) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Uzunlik (Longitude)</label>
                            <input type="number" name="longitude" class="form-control" step="0.0000001"
                                   value="{{ old('longitude', $species->longitude) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conservation -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-shield-check me-2"></i>Muhofaza holati</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Muhofaza darajasi</label>
                            <input type="text" name="conservation_level" class="form-control" value="{{ old('conservation_level', $species->conservation_level) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Populyatsiya</label>
                            <input type="text" name="conservation_population" class="form-control" value="{{ old('conservation_population', $species->conservation_population) }}">
                        </div>
                    </div>
                    @foreach(['uz' => "O'zbek", 'ru' => 'Rus', 'en' => 'Ingliz'] as $lang => $label)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Tahdidlar ({{ $label }})</label>
                            <textarea name="threats_{{ $lang }}" class="form-control" rows="4">{{ old('threats_'.$lang, is_array($species->{'threats_'.$lang}) ? implode("\n", $species->{'threats_'.$lang}) : '') }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Related -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-diagram-3 me-2"></i>Bog'liq turlar</h6>
            </div>
            <div class="card-body">
                <select name="related_species[]" class="form-select" multiple>
                    @foreach($allSpecies as $sp)
                        <option value="{{ $sp->id }}"
                            {{ in_array($sp->id, old('related_species', $species->related_species ?? [])) ? 'selected' : '' }}>
                            {{ $sp->name_uz }} ({{ $sp->scientific_name }})
                        </option>
                    @endforeach
                </select>
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
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px; margin-bottom:10px;">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $species->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active" style="font-size:14px; font-weight:500; cursor:pointer;">
                        <i class="bi bi-eye me-1"></i> Faol (ko'rinadi)
                    </label>
                </div>
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px;">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1"
                           {{ old('featured', $species->featured) ? 'checked' : '' }}>
                    <label class="form-check-label" for="featured" style="font-size:14px; font-weight:500; cursor:pointer;">
                        <i class="bi bi-star me-1" style="color:var(--secondary-dark);"></i> Featured
                    </label>
                </div>
            </div>
        </div>

        <!-- Current Main Image -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-image me-2"></i>Asosiy rasm</h6>
            </div>
            <div class="card-body">
                @if($species->image_main)
                    <div style="margin-bottom:12px;">
                        <img src="{{ $species->image_main }}" alt="" style="width:100%; border-radius:8px; border:1px solid var(--border);">
                    </div>
                @endif
                <div class="img-upload-area">
                    <input type="file" id="image_main" name="image_main" accept="image/*"
                           onchange="previewImage(this, 'preview_main', 5)">
                    <div class="img-upload-icon">📷</div>
                    <div class="img-upload-text">{{ $species->image_main ? 'Yangi rasm yuklash' : 'Rasm yuklash' }}</div>
                    <div class="img-upload-hint">PNG, JPG, WEBP &bull; Max 5MB</div>
                </div>
                <img id="preview_main" src="" alt="" class="img-preview" style="display:none;">
            </div>
        </div>

        <!-- Gallery -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-images me-2"></i>Galereya</h6>
            </div>
            <div class="card-body">
                @if(!empty($species->image_gallery))
                    <div class="gallery-grid mb-3">
                        @foreach($species->image_gallery as $img)
                            <div class="gallery-item" id="gallery-{{ md5($img) }}">
                                <img src="{{ $img }}" alt="">
                                <button type="button" class="remove-btn" onclick="removeGalleryImg('{{ $img }}', 'gallery-{{ md5($img) }}')">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div id="gallery-remove-inputs"></div>
                @endif
                <div class="img-upload-area">
                    <input type="file" name="image_gallery[]" accept="image/*" multiple onchange="previewNewGallery(this)">
                    <div class="img-upload-icon">🖼️</div>
                    <div class="img-upload-text">Yangi rasmlar qo'shish</div>
                    <div class="img-upload-hint">Bir nechta tanlash mumkin</div>
                </div>
                <div id="new-gallery-preview" class="gallery-grid"></div>
            </div>
        </div>

    </div>
</div>

<div style="margin-top:8px; display:flex; gap:8px; justify-content:flex-end;">
    <a href="{{ route('admin.species.index') }}" class="btn-secondary-custom">
        <i class="bi bi-x"></i> Bekor qilish
    </a>
    <button type="submit" class="btn-primary-custom">
        <i class="bi bi-check-lg"></i> Saqlash
    </button>
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

function removeGalleryImg(img, id) {
    document.getElementById(id)?.remove();
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'gallery_remove[]';
    input.value = img;
    document.getElementById('gallery-remove-inputs')?.appendChild(input);
}

function previewNewGallery(input) {
    const grid = document.getElementById('new-gallery-preview');
    grid.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'gallery-item';
            div.innerHTML = '<img src="' + e.target.result + '" alt="">';
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endpush
