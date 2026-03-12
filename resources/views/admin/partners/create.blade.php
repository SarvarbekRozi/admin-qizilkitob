@extends('layouts.admin')

@section('title', 'Yangi hamkor')
@section('page-title', 'Yangi hamkor')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.partners.index') }}">Hamkorlar</a>
    <span class="sep">/</span>
    <span>Yangi</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.partners.store') }}" enctype="multipart/form-data">
@csrf

<div class="page-header">
    <div class="page-header-left">
        <h1>Yangi hamkor qo'shish</h1>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.partners.index') }}" class="btn-secondary-custom">
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

    {{-- CHAP: asosiy ma'lumotlar --}}
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-translate me-2"></i>Nomi (ko'p tilli)</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">🇺🇿 O'zbekcha nomi <span class="req-badge">Majburiy</span></label>
                        <input type="text" name="name_uz" class="form-control" value="{{ old('name_uz') }}" required placeholder="Tashkilot nomi">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇷🇺 Ruscha nomi <span class="req-badge">Majburiy</span></label>
                        <input type="text" name="name_ru" class="form-control" value="{{ old('name_ru') }}" required placeholder="Название организации">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇬🇧 Inglizcha nomi <span class="req-badge">Majburiy</span></label>
                        <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" required placeholder="Organization name">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-card-text me-2"></i>Qisqa tavsif (ko'p tilli)</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">🇺🇿 Tavsif (O'zbek)</label>
                        <input type="text" name="description_uz" class="form-control" value="{{ old('description_uz') }}" placeholder="Tashkilot haqida qisqa ma'lumot">
                    </div>
                    <div class="col-12">
                        <label class="form-label">🇷🇺 Tavsif (Rus)</label>
                        <input type="text" name="description_ru" class="form-control" value="{{ old('description_ru') }}" placeholder="Краткое описание организации">
                    </div>
                    <div class="col-12">
                        <label class="form-label">🇬🇧 Tavsif (Ingliz)</label>
                        <input type="text" name="description_en" class="form-control" value="{{ old('description_en') }}" placeholder="Short description about the organization">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-sliders me-2"></i>Parametrlar</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-globe me-1"></i>Veb-sayt</label>
                        <input type="url" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://example.com">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Turi <span class="req-badge">Majburiy</span></label>
                        <select name="type" class="form-select" required>
                            <option value="international" {{ old('type') === 'international' ? 'selected' : '' }}>🌍 Xalqaro</option>
                            <option value="national" {{ old('type','national') === 'national' ? 'selected' : '' }}>🇺🇿 Milliy</option>
                            <option value="research" {{ old('type') === 'research' ? 'selected' : '' }}>🔬 Ilmiy</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tartib raqami</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                        <div class="form-hint">Kichik = avval ko'rinadi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- O'NG: logo + sozlamalar --}}
    <div class="col-lg-4">

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-image me-2"></i>Logo</h6>
            </div>
            <div class="card-body">
                <div class="img-upload-area" onclick="document.getElementById('partner_logo').click()">
                    <input type="file" id="partner_logo" name="logo" accept="image/*"
                           onchange="previewImage(this, 'preview_logo')">
                    <div class="img-upload-icon">🤝</div>
                    <div class="img-upload-text">Logo yuklash</div>
                    <div class="img-upload-hint">PNG, SVG, JPG, WebP &bull; Max 2MB</div>
                </div>
                <img id="preview_logo" src="" alt="" class="img-preview" style="display:none; object-fit:contain; background:#f9f9f9; border-radius:8px; margin-top:10px; max-height:120px; width:100%;">
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-gear me-2"></i>Holat</h6>
            </div>
            <div class="card-body">
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px; background:var(--body-bg); border-radius:8px;">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label class="form-check-label" for="is_active" style="cursor:pointer; font-size:14px; font-weight:500;">
                        <i class="bi bi-eye me-1"></i> Faol (saytda ko'rinadi)
                    </label>
                </div>
            </div>
        </div>

    </div>

</div>
</form>
@endsection
