@extends('layouts.admin')

@section('title', "Yangi jamoa a'zosi")
@section('page-title', "Yangi jamoa a'zosi")

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.team.index') }}">Jamoa</a>
    <span class="sep">/</span>
    <span>Yangi</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data">
@csrf

<div class="page-header">
    <div class="page-header-left">
        <h1>Yangi a'zo qo'shish</h1>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('admin.team.index') }}" class="btn-secondary-custom">
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
        <div>@foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach</div>
    </div>
@endif

<div class="row g-3">

    {{-- CHAP: ma'lumotlar --}}
    <div class="col-lg-8">

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-translate me-2"></i>Ismi (ko'p tilli)</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">🇺🇿 Ismi (O'zbek) <span class="req-badge">Majburiy</span></label>
                        <input type="text" name="name_uz" class="form-control" value="{{ old('name_uz') }}" required placeholder="To'liq ism">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇷🇺 Ismi (Rus)</label>
                        <input type="text" name="name_ru" class="form-control" value="{{ old('name_ru') }}" placeholder="Полное имя">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇬🇧 Ismi (Ingliz)</label>
                        <input type="text" name="name_en" class="form-control" value="{{ old('name_en') }}" placeholder="Full name">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-briefcase me-2"></i>Lavozimi (ko'p tilli)</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">🇺🇿 Lavozimi (O'zbek)</label>
                        <input type="text" name="position_uz" class="form-control" value="{{ old('position_uz') }}" placeholder="Bosh direktor">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇷🇺 Lavozimi (Rus)</label>
                        <input type="text" name="position_ru" class="form-control" value="{{ old('position_ru') }}" placeholder="Генеральный директор">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇬🇧 Lavozimi (Ingliz)</label>
                        <input type="text" name="position_en" class="form-control" value="{{ old('position_en') }}" placeholder="Director General">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-card-text me-2"></i>Bio (ko'p tilli)</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">🇺🇿 Bio (O'zbek)</label>
                        <input type="text" name="bio_uz" class="form-control" value="{{ old('bio_uz') }}" placeholder="Qisqa ma'lumot...">
                    </div>
                    <div class="col-12">
                        <label class="form-label">🇷🇺 Bio (Rus)</label>
                        <input type="text" name="bio_ru" class="form-control" value="{{ old('bio_ru') }}" placeholder="Краткая информация...">
                    </div>
                    <div class="col-12">
                        <label class="form-label">🇬🇧 Bio (Ingliz)</label>
                        <input type="text" name="bio_en" class="form-control" value="{{ old('bio_en') }}" placeholder="Short description...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-share me-2"></i>Ijtimoiy tarmoqlar</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label"><i class="bi bi-facebook me-1" style="color:#1877F2;"></i>Facebook</label>
                        <input type="url" name="facebook" class="form-control" value="{{ old('facebook') }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="bi bi-twitter-x me-1"></i>Twitter / X</label>
                        <input type="url" name="twitter" class="form-control" value="{{ old('twitter') }}" placeholder="https://x.com/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="bi bi-linkedin me-1" style="color:#0A66C2;"></i>LinkedIn</label>
                        <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/...">
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- O'NG: rasm + sozlamalar --}}
    <div class="col-lg-4">

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-person-circle me-2"></i>Rasm</h6>
            </div>
            <div class="card-body">
                <div class="img-upload-area" onclick="document.getElementById('team_image').click()">
                    <input type="file" id="team_image" name="image" accept="image/*"
                           onchange="previewImage(this, 'preview_team')">
                    <div class="img-upload-icon">👤</div>
                    <div class="img-upload-text">Rasm yuklash</div>
                    <div class="img-upload-hint">PNG, JPG, WebP &bull; Max 3MB</div>
                </div>
                <img id="preview_team" src="" alt="" class="img-preview"
                     style="display:none;width:100%;height:160px;object-fit:cover;border-radius:8px;margin-top:10px;">
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-gear me-2"></i>Sozlamalar</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Tartib raqami</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                    <div class="form-hint">Kichik = avval ko'rinadi</div>
                </div>
                <div class="form-check" style="display:flex;align-items:center;gap:10px;padding:12px;background:var(--body-bg);border-radius:8px;">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label class="form-check-label" for="is_active" style="cursor:pointer;font-size:14px;font-weight:500;">
                        <i class="bi bi-eye me-1"></i> Faol (saytda ko'rinadi)
                    </label>
                </div>
            </div>
        </div>

    </div>
</div>
</form>

@endsection
