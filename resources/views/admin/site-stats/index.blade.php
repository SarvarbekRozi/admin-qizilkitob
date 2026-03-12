@extends('layouts.admin')

@section('title', 'Sayt statistikasi')
@section('page-title', 'Sayt statistikasi')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <span>Sayt statistikasi</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Sayt statistikasi</h1>
        <p class="subtitle">Jami {{ $stats->total() }} ta ko'rsatkich</p>
    </div>
    <a href="{{ route('admin.site-stats.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-lg"></i> Yangi ko'rsatkich
    </a>
</div>

<div class="card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:60px;">Ikonka</th>
                    <th>Kalit (key)</th>
                    <th>Qiymat</th>
                    <th>Nomi (UZ)</th>
                    <th>Tartib</th>
                    <th>Status</th>
                    <th style="width:90px;">Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stats as $stat)
                    <tr>
                        <td style="text-align:center;">
                            <i class="{{ $stat->icon }}" style="font-size:20px; color:var(--primary);" title="{{ $stat->icon }}"></i>
                        </td>
                        <td>
                            <code style="font-size:12px; background:var(--body-bg); padding:2px 8px; border-radius:4px; color:var(--primary);">{{ $stat->key }}</code>
                        </td>
                        <td>
                            <span style="font-size:18px; font-weight:700; color:var(--primary);">{{ $stat->value }}</span>
                            <span style="font-size:14px; color:var(--secondary);">{{ $stat->suffix }}</span>
                        </td>
                        <td style="font-size:13px;">{{ $stat->label_uz }}</td>
                        <td style="font-size:13px; color:var(--text-muted);">{{ $stat->order }}</td>
                        <td>
                            <span class="badge {{ $stat->is_active ? 'badge-green' : 'badge-gray' }}">
                                {{ $stat->is_active ? 'Faol' : 'Nofaol' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <a href="{{ route('admin.site-stats.edit', $stat) }}" class="btn-icon edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.site-stats.destroy', $stat) }}" class="confirm-delete">
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
                        <td colspan="7" style="text-align:center; padding:48px; color:var(--text-muted);">
                            <i class="bi bi-bar-chart" style="font-size:40px; display:block; margin-bottom:12px;"></i>
                            Statistika ma'lumotlari topilmadi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($stats->hasPages())
        <div style="padding:16px 20px; border-top:1px solid var(--border);">
            <div class="pagination-wrapper" style="margin:0;">{{ $stats->links() }}</div>
        </div>
    @endif
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endpush
