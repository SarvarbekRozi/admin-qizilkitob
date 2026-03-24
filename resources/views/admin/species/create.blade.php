@extends('layouts.admin')

@section('title', 'Yangi tur qo\'shish')
@section('page-title', 'Yangi tur qo\'shish')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.species.index') }}">Turlar</a>
    <span class="sep">/</span>
    <span>Yangi</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.species.store') }}" enctype="multipart/form-data">
@csrf

<div class="page-header">
    <div class="page-header-left">
        <h1>Yangi tur qo'shish</h1>
        <p class="subtitle">Qizil kitobga yangi tur qo'shing</p>
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

    <!-- Left Column: Main content -->
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
                            <input type="text" name="scientific_name" class="form-control" value="{{ old('scientific_name') }}" placeholder="Panthera tigris" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Slug (URL)</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Avtomatik yaratiladi">
                            <div class="form-hint">Bo'sh qoldiring - o'zbekcha nomdan avtomatik yaratiladi</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Kategoriya <span class="req-badge">Majburiy</span></label>
                            <select name="category" class="form-select" required>
                                <option value="">Tanlang...</option>
                                <option value="animal" {{ old('category') === 'animal' ? 'selected' : '' }}>🦊 Hayvon</option>
                                <option value="plant" {{ old('category') === 'plant' ? 'selected' : '' }}>🌱 O'simlik</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Xavf darajasi <span class="req-badge">Majburiy</span></label>
                            <select name="danger_level" class="form-select" required>
                                <option value="">Tanlang...</option>
                                <option value="critically_endangered" {{ old('danger_level') === 'critically_endangered' ? 'selected' : '' }}>CR - Juda xavfli</option>
                                <option value="endangered" {{ old('danger_level') === 'endangered' ? 'selected' : '' }}>EN - Xavfli</option>
                                <option value="vulnerable" {{ old('danger_level') === 'vulnerable' ? 'selected' : '' }}>VU - Zaif</option>
                                <option value="near_threatened" {{ old('danger_level') === 'near_threatened' ? 'selected' : '' }}>NT - Deyarli tahdid</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multilingual names & descriptions -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-translate me-2"></i>Ko'p tilli ma'lumotlar</h6>
            </div>
            <div class="card-body">

                <!-- Language Tabs -->
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
                        <input type="text" name="name_{{ $lang }}" class="form-control" value="{{ old('name_'.$lang) }}" {{ $lang === 'uz' ? 'required' : '' }}>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Qisqa tavsif ({{ $langLabel }})</label>
                        <textarea name="description_short_{{ $lang }}" class="form-control" rows="3" placeholder="Qisqa tavsif...">{{ old('description_short_'.$lang) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">To'liq tavsif ({{ $langLabel }})</label>
                        <textarea name="description_full_{{ $lang }}" class="form-control" rows="6" placeholder="To'liq tavsif...">{{ old('description_full_'.$lang) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tavsif punktlari ({{ $langLabel }})</label>
                        <textarea name="description_bullets_{{ $lang }}" class="form-control" rows="4" placeholder="Har bir qatorda bir punkt...">{{ old('description_bullets_'.$lang) }}</textarea>
                        <div class="form-hint">Har qatorga bitta punkt yozing</div>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Og'irligi</label>
                            <input type="text" name="stat_mass" class="form-control" value="{{ old('stat_mass') }}" placeholder="200-300 kg">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tezligi</label>
                            <input type="text" name="stat_speed" class="form-control" value="{{ old('stat_speed') }}" placeholder="80 km/soat">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Umri</label>
                            <input type="text" name="stat_lifespan" class="form-control" value="{{ old('stat_lifespan') }}" placeholder="15-20 yil">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Oziqlanish</label>
                            <input type="text" name="stat_diet" class="form-control" value="{{ old('stat_diet') }}" placeholder="Go'shtxo'r">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Balandligi (o'simliklar)</label>
                            <input type="text" name="stat_height" class="form-control" value="{{ old('stat_height') }}" placeholder="2-3 m">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Gullash davri</label>
                            <input type="text" name="stat_bloom_period" class="form-control" value="{{ old('stat_bloom_period') }}" placeholder="Mart-May">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Yashash muhiti</label>
                            <input type="text" name="stat_habitat" class="form-control" value="{{ old('stat_habitat') }}" placeholder="Tog'lar, o'rmonlar...">
                        </div>
                    </div>
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Joylashuv (O'zbek)</label>
                            <input type="text" name="habitat_location_uz" class="form-control" value="{{ old('habitat_location_uz') }}" placeholder="Farg'ona vodiysi">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Joylashuv (Rus)</label>
                            <input type="text" name="habitat_location_ru" class="form-control" value="{{ old('habitat_location_ru') }}" placeholder="Ферганская долина">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Joylashuv (Ing)</label>
                            <input type="text" name="habitat_location_en" class="form-control" value="{{ old('habitat_location_en') }}" placeholder="Fergana Valley">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Kenglik (Latitude)</label>
                            <input type="number" name="latitude" class="form-control" value="{{ old('latitude') }}" step="0.0000001" placeholder="41.2995">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Uzunlik (Longitude)</label>
                            <input type="number" name="longitude" class="form-control" value="{{ old('longitude') }}" step="0.0000001" placeholder="69.2401">
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
                            <input type="text" name="conservation_level" class="form-control" value="{{ old('conservation_level') }}" placeholder="Qat'iy muhofaza">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Populyatsiya</label>
                            <input type="text" name="conservation_population" class="form-control" value="{{ old('conservation_population') }}" placeholder="~200 ta">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Tahdidlar (O'zbek)</label>
                            <textarea name="threats_uz" class="form-control" rows="4" placeholder="Har qatorda bir tahdid...">{{ old('threats_uz') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Tahdidlar (Rus)</label>
                            <textarea name="threats_ru" class="form-control" rows="4" placeholder="Каждая угроза на новой строке...">{{ old('threats_ru') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Tahdidlar (Ing)</label>
                            <textarea name="threats_en" class="form-control" rows="4" placeholder="Each threat on new line...">{{ old('threats_en') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related species -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-diagram-3 me-2"></i>Bog'liq turlar</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Bog'liq turlarni tanlang</label>
                    <select name="related_species[]" class="form-select" multiple>
                        @foreach($allSpecies as $sp)
                            <option value="{{ $sp->id }}"
                                {{ in_array($sp->id, old('related_species', [])) ? 'selected' : '' }}>
                                {{ $sp->name_uz }} ({{ $sp->scientific_name }})
                            </option>
                        @endforeach
                    </select>
                    <div class="form-hint">Ctrl tugmasi bilan bir nechta tanlash mumkin</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: Images & Settings -->
    <div class="col-lg-4">

        <!-- Settings -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-gear me-2"></i>Sozlamalar</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px; margin-bottom:10px;">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active" style="font-size:14px; font-weight:500; cursor:pointer;">
                            <i class="bi bi-eye me-1"></i> Faol (ko'rinadi)
                        </label>
                    </div>
                    <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px;">
                        <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured" style="font-size:14px; font-weight:500; cursor:pointer;">
                            <i class="bi bi-star me-1" style="color:var(--secondary-dark);"></i> Featured (ajratilgan)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Image -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-image me-2"></i>Asosiy rasm</h6>
            </div>
            <div class="card-body">
                <div class="img-upload-area">
                    <input type="file" id="image_main" name="image_main" accept="image/*"
                           onchange="previewImage(this, 'preview_main', 5)">
                    <div id="upload-icon-main">
                        <div class="img-upload-icon">📷</div>
                        <div class="img-upload-text">Rasm yuklash</div>
                        <div class="img-upload-hint">PNG, JPG, WEBP &bull; Max 5MB</div>
                    </div>
                </div>
                <img id="preview_main" src="" alt="" class="img-preview" style="display:none;">
            </div>
        </div>

        <!-- Gallery -->
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-images me-2"></i>Galereya rasmlari</h6>
            </div>
            <div class="card-body">
                <div class="img-upload-area">
                    <input type="file" name="image_gallery[]" accept="image/*" multiple id="gallery_input"
                           onchange="previewGallery(this)">
                    <div class="img-upload-icon">🖼️</div>
                    <div class="img-upload-text">Bir nechta rasm yuklash</div>
                    <div class="img-upload-hint">PNG, JPG, WEBP &bull; Max 5MB har biri</div>
                </div>
                <div id="gallery-preview" class="gallery-grid"></div>
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

function previewGallery(input) {
    const grid = document.getElementById('gallery-preview');
    grid.innerHTML = '';
    const maxMB = 5;
    const oversize = [];
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const sizeMB = file.size / (1024 * 1024);
            if (sizeMB > maxMB) {
                oversize.push(file.name + ' (' + sizeMB.toFixed(1) + 'MB)');
                return;
            }
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
    const oldErr = document.getElementById('gallery_error');
    if (oldErr) oldErr.remove();
    if (oversize.length) {
        input.value = '';
        grid.innerHTML = '';
        const error = document.createElement('div');
        error.id = 'gallery_error';
        error.className = 'alert alert-danger mt-2 py-2';
        error.style.fontSize = '13px';
        error.textContent = 'Quyidagi rasmlar ' + maxMB + 'MB dan katta: ' + oversize.join(', ');
        input.closest('.card-body').appendChild(error);
    }
}

// Auto-generate slug from name_uz
document.querySelector('[name="name_uz"]')?.addEventListener('input', function() {
    const slugField = document.querySelector('[name="slug"]');
    if (slugField && !slugField.value) {
        slugField.placeholder = 'Avtomatik: ' + this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '');
    }
});
</script>
@endpush
