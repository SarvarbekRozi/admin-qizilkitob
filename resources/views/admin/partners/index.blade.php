@extends('layouts.admin')

@section('title', 'Hamkorlar')
@section('page-title', 'Hamkorlar')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <span>Hamkorlar</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Hamkorlar</h1>
        <p class="subtitle">Jami {{ $partners->total() }} ta hamkor</p>
    </div>
    <a href="{{ route('admin.partners.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-lg"></i> Yangi hamkor
    </a>
</div>

<!-- Type filter tabs -->
<div style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
    <a href="{{ route('admin.partners.index') }}"
       class="btn-{{ !request('type') ? 'primary' : 'secondary' }}-custom" style="padding:6px 16px; font-size:13px;">
        Barchasi
    </a>
    @foreach(['international' => 'Xalqaro', 'national' => 'Milliy', 'research' => 'Ilmiy'] as $type => $label)
        <a href="{{ route('admin.partners.index', ['type' => $type]) }}"
           class="btn-{{ request('type') === $type ? 'primary' : 'secondary' }}-custom" style="padding:6px 16px; font-size:13px;">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:70px;">Logo</th>
                    <th>Nomi</th>
                    <th>Turi</th>
                    <th>Veb-sayt</th>
                    <th>Tartib</th>
                    <th>Status</th>
                    <th style="width:90px;">Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                    <tr>
                        <td>
                            @if($partner->logo)
                                <img src="{{ $partner->logo }}" alt="{{ $partner->name_uz }}"
                                     style="width:56px; height:40px; object-fit:contain; border:1px solid var(--border); border-radius:6px; padding:4px; background:#fff;">
                            @else
                                <div class="table-img-placeholder" style="width:56px; height:40px; font-size:22px;">🤝</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600; font-size:13px;">{{ $partner->name_uz }}</div>
                            <div style="font-size:11px; color:var(--text-muted);">{{ $partner->name_ru }}</div>
                        </td>
                        <td>
                            @php
                                $typeClasses = [
                                    'international' => 'badge-blue',
                                    'national'      => 'badge-green',
                                    'research'      => 'badge-gold',
                                ];
                            @endphp
                            <span class="badge {{ $typeClasses[$partner->type] ?? 'badge-gray' }}" style="font-size:10px;">
                                {{ $partner->type_label }}
                            </span>
                        </td>
                        <td>
                            @if($partner->website)
                                <a href="{{ $partner->website }}" target="_blank" style="font-size:12px; color:var(--primary);">
                                    <i class="bi bi-link-45deg"></i> Sayt
                                </a>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td style="font-size:13px; color:var(--text-muted);">{{ $partner->order }}</td>
                        <td>
                            <span class="badge {{ $partner->is_active ? 'badge-green' : 'badge-gray' }}">
                                {{ $partner->is_active ? 'Faol' : 'Nofaol' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <a href="{{ route('admin.partners.edit', $partner) }}" class="btn-icon edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" class="confirm-delete">
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
                            <i class="bi bi-inbox" style="font-size:40px; display:block; margin-bottom:12px;"></i>
                            Hamkorlar topilmadi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($partners->hasPages())
        <div style="padding:16px 20px; border-top:1px solid var(--border);">
            <div class="pagination-wrapper" style="margin:0;">{{ $partners->links() }}</div>
        </div>
    @endif
</div>

@endsection
