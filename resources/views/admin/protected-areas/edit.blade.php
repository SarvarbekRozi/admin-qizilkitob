@extends('layouts.admin')

@section('title', 'Muhofaza hududini tahrirlash')
@section('page-title', 'Muhofaza hududini tahrirlash')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.protected-areas.index') }}">Muhofaza hududlari</a>
    <span class="sep">/</span>
    <span>Tahrirlash</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.protected-areas.update', $protectedArea) }}">
@csrf @method('PUT')

<div class="page-header">
    <div class="page-header-left">
        <h1>{{ $protectedArea->name_uz }}</h1>
        <p class="subtitle">Muhofaza hududini tahrirlash</p>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.protected-areas.index') }}" class="btn-secondary-custom">
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

    {{-- LEFT: main data --}}
    <div class="col-lg-8">

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-translate me-2"></i>Nomi (ko'p tilli)</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">🇺🇿 O'zbekcha <span class="req-badge">Majburiy</span></label>
                        <input type="text" name="name_uz" class="form-control"
                               value="{{ old('name_uz', $protectedArea->name_uz) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇷🇺 Ruscha</label>
                        <input type="text" name="name_ru" class="form-control"
                               value="{{ old('name_ru', $protectedArea->name_ru) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇬🇧 Inglizcha</label>
                        <input type="text" name="name_en" class="form-control"
                               value="{{ old('name_en', $protectedArea->name_en) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-sliders me-2"></i>Qo'shimcha ma'lumotlar</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label"><i class="bi bi-link me-1"></i>Slug (URL)</label>
                        <input type="text" name="slug" class="form-control"
                               value="{{ old('slug', $protectedArea->slug) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="bi bi-123 me-1"></i>Soni matni</label>
                        <input type="text" name="count_text" class="form-control"
                               value="{{ old('count_text', $protectedArea->count_text) }}" placeholder="7 ta">
                        <div class="form-hint">Masalan: "7 ta", "12 ta"</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="bi bi-sort-numeric-up me-1"></i>Tartib raqami</label>
                        <input type="number" name="order" class="form-control"
                               value="{{ old('order', $protectedArea->order) }}" min="0">
                        <div class="form-hint">Kichik = avval ko'rinadi</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-emoji-smile me-2"></i>Ikonka tanlash (Font Awesome)</h6>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Ikonka klassi</label>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <input type="text" name="icon" id="icon_input" class="form-control"
                                   value="{{ old('icon', $protectedArea->icon) }}"
                                   oninput="updateIconPreview(this.value)">
                            <div style="width:44px; height:44px; border:2px solid var(--border); border-radius:8px;
                                        display:flex; align-items:center; justify-content:center; background:var(--body-bg); flex-shrink:0;">
                                <i id="icon_preview" class="{{ old('icon', $protectedArea->icon) }}"
                                   style="font-size:22px; color:var(--primary);"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-hint mb-2">Tez tanlash uchun ikonkani bosing:</div>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    @php
                        $icons = [
                            'fas fa-mountain'      => 'Tog\'',
                            'fas fa-map-marked-alt'=> 'Xarita',
                            'fas fa-tree'          => 'Daraxt',
                            'fas fa-landmark'      => 'Monument',
                            'fas fa-shield-alt'    => 'Qalqon',
                            'fas fa-horse'         => 'Ot',
                            'fas fa-globe-americas'=> 'Globus',
                            'fas fa-leaf'          => 'Barg',
                            'fas fa-seedling'      => 'Nihal',
                            'fas fa-water'         => 'Suv',
                            'fas fa-sun'           => 'Quyosh',
                            'fas fa-spa'           => 'Gul',
                        ];
                        $currentIcon = old('icon', $protectedArea->icon);
                    @endphp
                    @foreach($icons as $cls => $label)
                        <button type="button"
                                onclick="selectIcon('{{ $cls }}')"
                                title="{{ $label }}: {{ $cls }}"
                                style="width:52px; height:52px; border:2px solid {{ $currentIcon === $cls ? 'var(--primary)' : 'var(--border)' }};
                                       border-radius:10px; background:{{ $currentIcon === $cls ? 'rgba(160,51,45,0.07)' : '#fff' }};
                                       cursor:pointer; display:flex; flex-direction:column;
                                       align-items:center; justify-content:center; gap:3px; transition:all 0.15s;"
                                onmouseover="this.style.borderColor='var(--primary)';"
                                onmouseout="resetBtnStyle(this, '{{ $cls }}');">
                            <i class="{{ $cls }}" style="font-size:18px; color:var(--primary);"></i>
                            <span style="font-size:8px; color:var(--text-muted); line-height:1;">{{ $label }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT: status --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-gear me-2"></i>Holat</h6>
            </div>
            <div class="card-body">
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px;
                            background:var(--body-bg); border-radius:8px;">
                    <input class="form-check-input" type="checkbox" name="is_active"
                           id="is_active" value="1"
                           {{ old('is_active', $protectedArea->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active"
                           style="cursor:pointer; font-size:14px; font-weight:500;">
                        <i class="bi bi-eye me-1"></i> Faol (saytda ko'rinadi)
                    </label>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6><i class="bi bi-info-circle me-2"></i>Ma'lumot</h6>
            </div>
            <div class="card-body" style="font-size:12px; color:var(--text-muted);">
                <div>Yaratilgan: {{ $protectedArea->created_at->format('d.m.Y H:i') }}</div>
                <div>Yangilangan: {{ $protectedArea->updated_at->format('d.m.Y H:i') }}</div>
            </div>
        </div>
    </div>

</div>
</form>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endpush

@push('scripts')
<script>
const currentIcon = '{{ old('icon', $protectedArea->icon) }}';

function updateIconPreview(cls) {
    document.getElementById('icon_preview').className = cls;
}

function selectIcon(cls) {
    document.getElementById('icon_input').value = cls;
    updateIconPreview(cls);
    document.querySelectorAll('[onclick^="selectIcon"]').forEach(btn => {
        btn.style.borderColor = 'var(--border)';
        btn.style.background = '#fff';
    });
    event.currentTarget.style.borderColor = 'var(--primary)';
    event.currentTarget.style.background = 'rgba(160,51,45,0.07)';
}

function resetBtnStyle(btn, cls) {
    const current = document.getElementById('icon_input').value;
    if (current === cls) {
        btn.style.borderColor = 'var(--primary)';
        btn.style.background = 'rgba(160,51,45,0.07)';
    } else {
        btn.style.borderColor = 'var(--border)';
        btn.style.background = '#fff';
    }
}
</script>
@endpush
