@extends('layouts.admin')

@section('title', 'Tabiiy boyliklar')
@section('page-title', 'Tabiiy boyliklar')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <span>Tabiiy boyliklar</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Tabiiy boyliklar</h1>
        <p class="subtitle">O'zbekistonning muhofaza qilinadigan tabiiy boyliklari</p>
    </div>
    <a href="{{ route('admin.natural-resources.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-lg"></i> Yangi boylik
    </a>
</div>

<!-- Filters -->
<div class="filters-bar">
    <form method="GET" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; width:100%;">
        <div class="form-group" style="flex:1; min-width:200px;">
            <label class="form-label">Qidirish</label>
            <div style="position:relative;">
                <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:14px;"></i>
                <input type="text" name="search" class="form-control" placeholder="Nom..."
                       value="{{ request('search') }}" style="padding-left:36px;">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Kategoriya</label>
            <select name="category" class="form-select">
                <option value="">Barchasi</option>
                @foreach($protectedAreas as $area)
                    <option value="{{ $area->slug }}" {{ request('category') === $area->slug ? 'selected' : '' }}>
                        {{ $area->name_uz }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-funnel"></i> Filter</button>
            @if(request()->hasAny(['search', 'category']))
                <a href="{{ route('admin.natural-resources.index') }}" class="btn-secondary-custom ms-2">
                    <i class="bi bi-x"></i> Tozalash
                </a>
            @endif
        </div>
    </form>
</div>

<div class="card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:60px;">Rasm</th>
                    <th>Nomi</th>
                    <th>Kategoriya</th>
                    <th>Ko'rishlar</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th>Sana</th>
                    <th style="width:90px;">Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resources as $resource)
                    <tr>
                        <td>
                            @if($resource->image)
                                <img src="{{ $resource->image }}" alt="" class="table-img">
                            @else
                                <div class="table-img-placeholder">🌲</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600; font-size:13px;">{{ Str::limit($resource->title_uz, 40) }}</div>
                            <div style="font-size:11px; color:var(--text-muted);">{{ Str::limit($resource->title_ru, 40) }}</div>
                        </td>
                        <td>
                            @if($resource->category)
                                <span class="badge badge-green" style="font-size:10px;">
                                    {{ $areasMap[$resource->category] ?? $resource->category }}
                                </span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td style="font-size:13px; color:var(--text-muted);">
                            <i class="bi bi-eye"></i> {{ number_format($resource->views_count) }}
                        </td>
                        <td>
                            @if($resource->featured)
                                <span class="badge badge-gold" style="font-size:10px;"><i class="bi bi-star-fill"></i> Ha</span>
                            @else
                                <span style="color:var(--text-muted); font-size:12px;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $resource->is_active ? 'badge-green' : 'badge-gray' }}">
                                {{ $resource->is_active ? 'Faol' : 'Nofaol' }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:var(--text-muted);">
                            {{ $resource->created_at->format('d.m.Y') }}
                        </td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <a href="{{ route('admin.natural-resources.edit', $resource) }}" class="btn-icon edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.natural-resources.destroy', $resource) }}" class="confirm-delete">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:48px; color:var(--text-muted);">
                            <i class="bi bi-inbox" style="font-size:40px; display:block; margin-bottom:12px;"></i>
                            Tabiiy boyliklar topilmadi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($resources->hasPages())
        <div style="padding:16px 20px; border-top:1px solid var(--border);">
            <div class="d-flex justify-content-between align-items-center">
                <div style="font-size:13px; color:var(--text-muted);">Jami: {{ $resources->total() }}</div>
                <div class="pagination-wrapper" style="margin:0;">{{ $resources->links() }}</div>
            </div>
        </div>
    @endif
</div>

@endsection
