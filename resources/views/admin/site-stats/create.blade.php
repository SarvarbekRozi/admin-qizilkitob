@extends('layouts.admin')

@section('title', 'Yangi statistika')
@section('page-title', 'Yangi statistika')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.site-stats.index') }}">Sayt statistikasi</a>
    <span class="sep">/</span>
    <span>Yangi</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.site-stats.store') }}">
@csrf

<div class="page-header">
    <div class="page-header-left">
        <h1>Yangi statistika ko'rsatkichi qo'shish</h1>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.site-stats.index') }}" class="btn-secondary-custom">
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

    {{-- LEFT --}}
    <div class="col-lg-8">

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-key me-2"></i>Asosiy ma'lumotlar</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Kalit (key) <span class="req-badge">Majburiy</span></label>
                        <input type="text" name="key" class="form-control"
                               value="{{ old('key') }}" required
                               placeholder="animals">
                        <div class="form-hint">Masalan: animals, plants, zones, researchers</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Qiymat (value) <span class="req-badge">Majburiy</span></label>
                        <input type="text" name="value" class="form-control"
                               value="{{ old('value') }}" required
                               placeholder="120">
                        <div class="form-hint">Raqam yoki matn</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Qo'shimcha belgi (suffix)</label>
                        <input type="text" name="suffix" class="form-control"
                               value="{{ old('suffix', '+') }}"
                               placeholder="+">
                        <div class="form-hint">Masalan: "+", "", " ta"</div>
                    </div>
                </div>

                {{-- Live preview --}}
                <div style="margin-top:16px; padding:16px; background:var(--body-bg); border-radius:10px; text-align:center;">
                    <div style="font-size:12px; color:var(--text-muted); margin-bottom:8px;">Ko'rinish:</div>
                    <div style="font-size:32px; font-weight:700; color:var(--primary);">
                        <span id="preview_value">120</span><span id="preview_suffix" style="color:var(--secondary);">+</span>
                    </div>
                    <div style="font-size:13px; color:var(--text-muted);" id="preview_label">Hayvonlar</div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-translate me-2"></i>Nomi / Yorliq (ko'p tilli)</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">🇺🇿 O'zbekcha <span class="req-badge">Majburiy</span></label>
                        <input type="text" name="label_uz" class="form-control"
                               value="{{ old('label_uz') }}" required
                               placeholder="Hayvonlar"
                               oninput="document.getElementById('preview_label').textContent = this.value || 'Yorliq'">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇷🇺 Ruscha</label>
                        <input type="text" name="label_ru" class="form-control"
                               value="{{ old('label_ru') }}" placeholder="Животные">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">🇬🇧 Inglizcha</label>
                        <input type="text" name="label_en" class="form-control"
                               value="{{ old('label_en') }}" placeholder="Animals">
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
                                   value="{{ old('icon', 'fas fa-chart-bar') }}"
                                   placeholder="fas fa-chart-bar"
                                   oninput="updateIconPreview(this.value)">
                            <div style="width:44px; height:44px; border:2px solid var(--border); border-radius:8px;
                                        display:flex; align-items:center; justify-content:center; background:var(--body-bg); flex-shrink:0;">
                                <i id="icon_preview" class="{{ old('icon', 'fas fa-chart-bar') }}"
                                   style="font-size:22px; color:var(--primary);"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-hint mb-2">Tez tanlash uchun ikonkani bosing:</div>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    @php
                        $icons = [
                            'fas fa-paw'         => 'Panja',
                            'fas fa-seedling'    => 'Nihal',
                            'fas fa-layer-group' => 'Zonalar',
                            'fas fa-user-graduate'=> 'Olim',
                            'fas fa-chart-bar'   => 'Grafik',
                            'fas fa-mountain'    => 'Tog\'',
                            'fas fa-tree'        => 'Daraxt',
                            'fas fa-leaf'        => 'Barg',
                            'fas fa-fish'        => 'Baliq',
                            'fas fa-dove'        => 'Kabutar',
                            'fas fa-microscope'  => 'Mikroskop',
                            'fas fa-globe'       => 'Globus',
                        ];
                    @endphp
                    @foreach($icons as $cls => $label)
                        <button type="button"
                                onclick="selectIcon('{{ $cls }}')"
                                title="{{ $label }}: {{ $cls }}"
                                style="width:52px; height:52px; border:2px solid var(--border); border-radius:10px;
                                       background:#fff; cursor:pointer; display:flex; flex-direction:column;
                                       align-items:center; justify-content:center; gap:3px; transition:all 0.15s;"
                                onmouseover="this.style.borderColor='var(--primary)'; this.style.background='var(--body-bg)';"
                                onmouseout="this.style.borderColor='var(--border)'; this.style.background='#fff';">
                            <i class="{{ $cls }}" style="font-size:18px; color:var(--primary);"></i>
                            <span style="font-size:8px; color:var(--text-muted); line-height:1;">{{ $label }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT --}}
    <div class="col-lg-4">

        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-sort-numeric-up me-2"></i>Tartib</h6>
            </div>
            <div class="card-body">
                <label class="form-label">Tartib raqami</label>
                <input type="number" name="order" class="form-control"
                       value="{{ old('order', 0) }}" min="0">
                <div class="form-hint">Kichik = avval ko'rinadi</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-gear me-2"></i>Holat</h6>
            </div>
            <div class="card-body">
                <div class="form-check" style="display:flex; align-items:center; gap:10px; padding:12px;
                            background:var(--body-bg); border-radius:8px;">
                    <input class="form-check-input" type="checkbox" name="is_active"
                           id="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active"
                           style="cursor:pointer; font-size:14px; font-weight:500;">
                        <i class="bi bi-eye me-1"></i> Faol (saytda ko'rinadi)
                    </label>
                </div>
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
// Live preview for value & suffix
document.querySelector('[name="value"]').addEventListener('input', function() {
    document.getElementById('preview_value').textContent = this.value || '0';
});
document.querySelector('[name="suffix"]').addEventListener('input', function() {
    document.getElementById('preview_suffix').textContent = this.value;
});

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
</script>
@endpush
