@extends('layouts.admin')

@section('title', "A'zoni tahrirlash")
@section('page-title', "A'zoni tahrirlash")

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.team.index') }}">Jamoa</a>
    <span class="sep">/</span>
    <span>{{ $team->name_uz }}</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.team.update', $team) }}" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="page-header">
    <div class="page-header-left">
        <h1>{{ $team->name_uz }}</h1>
        <p class="subtitle">{{ $team->position_uz ?? "Jamoa a'zosi" }}</p>
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

@if(session('success'))
    <div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
@endif

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
                        <input type="text" name="name_uz" class="form-control" value="{{ old('name_uz', $team->name_uz) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇷🇺 Ismi (Rus)</label>
                        <input type="text" name="name_ru" class="form-control" value="{{ old('name_ru', $team->name_ru) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇬🇧 Ismi (Ingliz)</label>
                        <input type="text" name="name_en" class="form-control" value="{{ old('name_en', $team->name_en) }}">
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
                        <input type="text" name="position_uz" class="form-control" value="{{ old('position_uz', $team->position_uz) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇷🇺 Lavozimi (Rus)</label>
                        <input type="text" name="position_ru" class="form-control" value="{{ old('position_ru', $team->position_ru) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇬🇧 Lavozimi (Ingliz)</label>
                        <input type="text" name="position_en" class="form-control" value="{{ old('position_en', $team->position_en) }}">
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
                        <input type="text" name="bio_uz" class="form-control" value="{{ old('bio_uz', $team->bio_uz) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">🇷🇺 Bio (Rus)</label>
                        <input type="text" name="bio_ru" class="form-control" value="{{ old('bio_ru', $team->bio_ru) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">🇬🇧 Bio (Ingliz)</label>
                        <input type="text" name="bio_en" class="form-control" value="{{ old('bio_en', $team->bio_en) }}">
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
                        <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $team->facebook) }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="bi bi-twitter-x me-1"></i>Twitter / X</label>
                        <input type="url" name="twitter" class="form-control" value="{{ old('twitter', $team->twitter) }}" placeholder="https://x.com/...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="bi bi-linkedin me-1" style="color:#0A66C2;"></i>LinkedIn</label>
                        <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $team->linkedin) }}" placeholder="https://linkedin.com/in/...">
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
                @if($team->image)
                    <div style="margin-bottom:12px;text-align:center;">
                        <img src="{{ $team->image }}" alt="{{ $team->name_uz }}"
                             style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid var(--border);">
                        <div style="margin-top:6px;font-size:12px;color:#999;">Mavjud rasm</div>
                    </div>
                @endif
                <div class="img-upload-area">
                    <input type="file" id="team_image" name="image" accept="image/*"
                           onchange="previewImage(this, 'preview_team', 3)">
                    <div class="img-upload-icon">👤</div>
                    <div class="img-upload-text">{{ $team->image ? 'Yangi rasm yuklash' : 'Rasm yuklash' }}</div>
                    <div class="img-upload-hint">PNG, JPG, WebP &bull; Max 3MB</div>
                </div>
                <img id="preview_team" src="" alt="" class="img-preview"
                     style="display:none;width:100%;height:160px;object-fit:cover;border-radius:8px;margin-top:10px;">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-gear me-2"></i>Sozlamalar</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Tartib raqami</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $team->order) }}" min="0">
                    <div class="form-hint">Kichik = avval ko'rinadi</div>
                </div>
                <div class="form-check" style="display:flex;align-items:center;gap:10px;padding:12px;background:var(--body-bg);border-radius:8px;">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $team->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active" style="cursor:pointer;font-size:14px;font-weight:500;">
                        <i class="bi bi-eye me-1"></i> Faol (saytda ko'rinadi)
                    </label>
                </div>
            </div>
        </div>

    </div>
</div>
</form>

{{-- O'chirish formasi ASOSIY FORMADAN TASHQARIDA --}}
<div class="row g-3 mt-0">
    <div class="col-lg-4 offset-lg-8">
        <div class="card" style="border-color:#fee2e2;">
            <div class="card-header" style="background:#fff5f5;">
                <h6 style="color:#dc2626;"><i class="bi bi-trash me-2"></i>O'chirish</h6>
            </div>
            <div class="card-body">
                <p style="font-size:13px;color:#666;margin-bottom:12px;">Bu a'zoni butunlay o'chirish</p>
                <form method="POST" action="{{ route('admin.team.destroy', $team) }}"
                      onsubmit="return confirm('Rostdan ham o\'chirmoqchimisiz?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-trash me-1"></i> O'chirish
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
