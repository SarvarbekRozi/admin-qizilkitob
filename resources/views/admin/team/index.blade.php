@extends('layouts.admin')

@section('title', 'Jamoa a\'zolari')
@section('page-title', 'Jamoa a\'zolari')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <span>Jamoa</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Bizning jamoa</h1>
        <p class="subtitle">Haqimizda sahifasidagi jamoa a'zolari</p>
    </div>
    <a href="{{ route('admin.team.create') }}" class="btn-primary-custom">
        <i class="bi bi-plus-lg"></i> Yangi a'zo
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:60px;">Rasm</th>
                    <th>Ismi</th>
                    <th>Lavozimi</th>
                    <th style="width:80px;">Tartib</th>
                    <th style="width:90px;">Holat</th>
                    <th style="width:110px;">Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>
                        @if($member->image)
                            <img src="{{ $member->image }}" alt="{{ $member->name_uz }}"
                                 style="width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid var(--border);">
                        @else
                            <div style="width:46px;height:46px;border-radius:50%;background:var(--primary-color);color:#fff;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;">
                                {{ strtoupper(mb_substr($member->name_uz, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;color:var(--heading-color);">{{ $member->name_uz }}</div>
                        @if($member->name_ru)
                            <div style="font-size:12px;color:var(--text-muted);">{{ $member->name_ru }}</div>
                        @endif
                    </td>
                    <td>
                        <span style="font-size:13px;color:var(--primary-color);font-weight:500;">
                            {{ $member->position_uz ?? '—' }}
                        </span>
                    </td>
                    <td><span class="badge badge-blue">{{ $member->order }}</span></td>
                    <td>
                        @if($member->is_active)
                            <span class="badge badge-green">Faol</span>
                        @else
                            <span class="badge badge-red">Nofaol</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.team.edit', $member) }}" class="btn-icon" title="Tahrirlash">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.team.destroy', $member) }}"
                                  onsubmit="return confirm('O\'chirishni tasdiqlaysizmi?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-icon-danger" title="O'chirish">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding:40px;color:var(--text-muted);">
                        <i class="bi bi-people" style="font-size:32px;display:block;margin-bottom:10px;"></i>
                        Hali jamoa a'zolari qo'shilmagan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($members->hasPages())
    <div style="margin-top:20px;">{{ $members->links() }}</div>
@endif

@endsection
