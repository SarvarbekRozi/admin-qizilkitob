@extends('layouts.admin')

@section('title', 'Muhofaza hududlari')
@section('page-title', 'Muhofaza hududlari')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <span>Muhofaza hududlari</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Muhofaza hududlari</h1>
        <p class="subtitle">Jami {{ $areas->total() }} ta hudud</p>
    </div>
    <a href="{{ route('admin.protected-areas.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-lg"></i> Yangi hudud
    </a>
</div>

<div class="card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:60px;">Tartib</th>
                    <th>Nomi</th>
                    <th>Soni</th>
                    <th style="width:80px;">Ikonka</th>
                    <th>Status</th>
                    <th style="width:90px;">Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($areas as $area)
                    <tr>
                        <td style="font-size:13px; color:var(--text-muted); text-align:center;">
                            <i class="bi bi-grip-vertical" style="color:var(--border); margin-right:4px;" title="Tartibni o'zgartirish uchun tartib raqamini tahrirlang"></i>
                            {{ $area->order }}
                        </td>
                        <td>
                            <div style="font-weight:600; font-size:13px;">{{ $area->name_uz }}</div>
                            <div style="font-size:11px; color:var(--text-muted);">{{ $area->name_ru }}</div>
                            <div style="font-size:10px; color:var(--text-muted); font-family:monospace;">{{ $area->slug }}</div>
                        </td>
                        <td style="font-size:13px;">
                            {{ $area->count_text ?: '—' }}
                        </td>
                        <td style="text-align:center;">
                            <i class="{{ $area->icon }}" style="font-size:20px; color:var(--primary);" title="{{ $area->icon }}"></i>
                        </td>
                        <td>
                            <span class="badge {{ $area->is_active ? 'badge-green' : 'badge-gray' }}">
                                {{ $area->is_active ? 'Faol' : 'Nofaol' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <a href="{{ route('admin.protected-areas.edit', $area) }}" class="btn-icon edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.protected-areas.destroy', $area) }}" class="confirm-delete">
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
                        <td colspan="6" style="text-align:center; padding:48px; color:var(--text-muted);">
                            <i class="bi bi-shield" style="font-size:40px; display:block; margin-bottom:12px;"></i>
                            Muhofaza hududlari topilmadi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($areas->hasPages())
        <div style="padding:16px 20px; border-top:1px solid var(--border);">
            <div class="pagination-wrapper" style="margin:0;">{{ $areas->links() }}</div>
        </div>
    @endif
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endpush
