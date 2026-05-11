@extends('layouts.admin')

@section('title', 'Turlar')
@section('page-title', 'Turlar')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh sahifa</a>
    <span class="sep">/</span>
    <span>Turlar</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Turlar ro'yxati</h1>
        <p class="subtitle">Qizil kitobga kiritilgan hayvon va o'simlik turlari</p>
    </div>
    <a href="{{ route('admin.species.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-lg"></i> Yangi tur qo'shish
    </a>
</div>

<!-- Filters -->
<div class="filters-bar">
    <form method="GET" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; width:100%;">
        <div class="form-group" style="flex:1; min-width:200px;">
            <label class="form-label">Qidirish</label>
            <div style="position:relative;">
                <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:14px;"></i>
                <input type="text" name="search" class="form-control" placeholder="Nomi yoki ilmiy nom..."
                       value="{{ request('search') }}" style="padding-left:36px;">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Kategoriya</label>
            <select name="category" class="form-select">
                <option value="">Barchasi</option>
                <option value="animal" {{ request('category') === 'animal' ? 'selected' : '' }}>Hayvonlar</option>
                <option value="plant" {{ request('category') === 'plant' ? 'selected' : '' }}>O'simliklar</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Oila / Sinf</label>
            <select name="family_id" class="form-select">
                <option value="">Barchasi</option>
                @foreach ($families as $f)
                    <option value="{{ $f->id }}" {{ (string) request('family_id') === (string) $f->id ? 'selected' : '' }}>
                        {{ $f->category === 'animal' ? '🦊' : '🌱' }} {{ $f->name_uz }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Xavf darajasi</label>
            <select name="danger_level" class="form-select">
                <option value="">Barchasi</option>
                <option value="critically_endangered" {{ request('danger_level') === 'critically_endangered' ? 'selected' : '' }}>Juda xavfli</option>
                <option value="endangered" {{ request('danger_level') === 'endangered' ? 'selected' : '' }}>Xavfli</option>
                <option value="vulnerable" {{ request('danger_level') === 'vulnerable' ? 'selected' : '' }}>Zaif</option>
                <option value="near_threatened" {{ request('danger_level') === 'near_threatened' ? 'selected' : '' }}>Deyarli tahdid</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-funnel"></i> Filter
            </button>
            @if(request()->hasAny(['search', 'category', 'family_id', 'danger_level']))
                <a href="{{ route('admin.species.index') }}" class="btn-secondary-custom ms-2">
                    <i class="bi bi-x"></i> Tozalash
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Table -->
<div class="card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:60px;">Rasm</th>
                    <th>Nomi</th>
                    <th>Ilmiy nomi</th>
                    <th>Kategoriya</th>
                    <th>Oila</th>
                    <th>Xavf darajasi</th>
                    <th>Ko'rishlar</th>
                    <th>Status</th>
                    <th style="width:120px;">Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($species as $sp)
                    <tr>
                        <td>
                            @if($sp->image_main)
                                <img src="{{ $sp->image_main }}" alt="{{ $sp->name_uz }}" class="table-img">
                            @else
                                <div class="table-img-placeholder">
                                    {{ $sp->category === 'animal' ? '🦋' : '🌿' }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600; font-size:13px;">{{ $sp->name_uz }}</div>
                            <div style="font-size:11px; color:var(--text-muted);">{{ $sp->name_ru }}</div>
                            @if($sp->featured)
                                <span class="badge badge-gold" style="font-size:10px; margin-top:3px;">
                                    <i class="bi bi-star-fill"></i> Featured
                                </span>
                            @endif
                        </td>
                        <td style="font-style:italic; font-size:13px; color:var(--text-muted);">
                            {{ $sp->scientific_name }}
                        </td>
                        <td>
                            <span class="badge {{ $sp->category === 'animal' ? 'badge-animal' : 'badge-plant' }}">
                                {{ $sp->category === 'animal' ? '🦊 Hayvon' : '🌱 O\'simlik' }}
                            </span>
                        </td>
                        <td style="font-size:12px;">
                            @if ($sp->family)
                                <div style="font-weight:500;">{{ $sp->family->name_uz }}</div>
                                @if ($sp->family->latin_name)
                                    <div style="font-size:10px; color:var(--text-muted); font-style:italic;">{{ $sp->family->latin_name }}</div>
                                @endif
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $dangerLabels = [
                                    'critically_endangered' => ['label' => 'CR - Juda xavfli', 'class' => 'badge-red'],
                                    'endangered'            => ['label' => 'EN - Xavfli', 'class' => 'badge-orange'],
                                    'vulnerable'            => ['label' => 'VU - Zaif', 'class' => 'badge-blue'],
                                    'near_threatened'       => ['label' => 'NT - Deyarli tahdid', 'class' => 'badge-gray'],
                                ];
                                $dl = $dangerLabels[$sp->danger_level] ?? ['label' => $sp->danger_level, 'class' => 'badge-gray'];
                            @endphp
                            <span class="badge {{ $dl['class'] }}" style="font-size:10px;">{{ $dl['label'] }}</span>
                        </td>
                        <td style="font-size:13px; color:var(--text-muted);">
                            <i class="bi bi-eye"></i> {{ number_format($sp->views_count) }}
                        </td>
                        <td>
                            <span class="badge {{ $sp->is_active ? 'badge-green' : 'badge-gray' }}">
                                {{ $sp->is_active ? 'Faol' : 'Nofaol' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <a href="{{ route('admin.species.edit', $sp) }}" class="btn-icon edit" title="Tahrirlash">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.species.destroy', $sp) }}" class="confirm-delete">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="O'chirish">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:48px; color:var(--text-muted);">
                            <i class="bi bi-inbox" style="font-size:40px; display:block; margin-bottom:12px;"></i>
                            Turlar topilmadi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($species->hasPages())
        <div style="padding:16px 20px; border-top:1px solid var(--border);">
            <div class="d-flex align-items-center justify-content-between">
                <div style="font-size:13px; color:var(--text-muted);">
                    Jami: {{ $species->total() }} ta tur
                </div>
                <div class="pagination-wrapper" style="margin-top:0;">
                    {{ $species->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
