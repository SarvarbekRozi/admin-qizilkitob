@extends('layouts.admin')

@section('title', $species->name_uz)
@section('page-title', $species->name_uz)

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.species.index') }}">Turlar</a>
    <span class="sep">/</span>
    <span>Ko'rish</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>{{ $species->name_uz }}</h1>
        <p class="subtitle" style="font-style:italic;">{{ $species->scientific_name }}</p>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.species.index') }}" class="btn-secondary-custom">
            <i class="bi bi-arrow-left"></i> Orqaga
        </a>
        <a href="{{ route('admin.species.edit', $species) }}" class="btn-primary-custom">
            <i class="bi bi-pencil"></i> Tahrirlash
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                @if($species->image_main)
                    <img src="{{ $species->image_main }}" alt="{{ $species->name_uz }}"
                         style="width:100%; max-height:400px; object-fit:cover; border-radius:10px; margin-bottom:20px;">
                @endif

                <div class="detail-label">O'zbekcha nomi</div>
                <div class="detail-value" style="font-size:20px; font-weight:700; margin-bottom:12px;">{{ $species->name_uz }}</div>

                @if($species->description_short_uz)
                    <div class="detail-label">Qisqa tavsif</div>
                    <div class="detail-value" style="margin-bottom:16px;">{{ $species->description_short_uz }}</div>
                @endif

                @if($species->description_full_uz)
                    <div class="detail-label">To'liq tavsif</div>
                    <div class="detail-value" style="line-height:1.7;">{{ $species->description_full_uz }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6>Ma'lumotlar</h6>
            </div>
            <div class="card-body" style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <div class="detail-label">Kategoriya</div>
                    <span class="badge {{ $species->category === 'animal' ? 'badge-animal' : 'badge-plant' }}">
                        {{ $species->category === 'animal' ? '🦊 Hayvon' : '🌱 O\'simlik' }}
                    </span>
                </div>
                <div>
                    <div class="detail-label">Xavf darajasi</div>
                    <span class="badge badge-{{ $species->danger_level_color }}">{{ $species->danger_level_label }}</span>
                </div>
                <div>
                    <div class="detail-label">Ko'rishlar</div>
                    <div class="detail-value">{{ number_format($species->views_count) }}</div>
                </div>
                <div>
                    <div class="detail-label">Status</div>
                    <span class="badge {{ $species->is_active ? 'badge-green' : 'badge-gray' }}">
                        {{ $species->is_active ? 'Faol' : 'Nofaol' }}
                    </span>
                </div>
                @if($species->featured)
                    <div>
                        <span class="badge badge-gold"><i class="bi bi-star-fill"></i> Featured</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
