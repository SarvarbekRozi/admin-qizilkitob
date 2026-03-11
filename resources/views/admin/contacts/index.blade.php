@extends('layouts.admin')

@section('title', 'Xabarnomalar')
@section('page-title', 'Xabarnomalar')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <span>Xabarnomalar</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Xabarnomalar</h1>
        <p class="subtitle">
            Jami {{ $contacts->total() }} ta xabar
            @if($unreadCount > 0)
                &mdash; <span style="color:var(--primary); font-weight:600;">{{ $unreadCount }} ta o'qilmagan</span>
            @endif
        </p>
    </div>
</div>

<!-- Filters -->
<div class="filters-bar">
    <form method="GET" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; width:100%;">
        <div class="form-group" style="flex:1; min-width:200px;">
            <label class="form-label">Qidirish</label>
            <div style="position:relative;">
                <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:14px;"></i>
                <input type="text" name="search" class="form-control" placeholder="Ism, email, mavzu..."
                       value="{{ request('search') }}" style="padding-left:36px;">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Holat</label>
            <select name="status" class="form-select">
                <option value="">Barchasi</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>O'qilmagan</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>O'qilgan</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-funnel"></i> Filter</button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.contacts.index') }}" class="btn-secondary-custom ms-2">
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
                    <th style="width:16px;"></th>
                    <th>Ismi</th>
                    <th>Email</th>
                    <th>Mavzu</th>
                    <th>Xabar</th>
                    <th>Sana</th>
                    <th>Holat</th>
                    <th style="width:110px;">Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr class="{{ !$contact->is_read ? 'unread-row' : '' }}">
                        <td style="padding-right:0;">
                            @if(!$contact->is_read)
                                <span class="unread-dot" title="O'qilmagan"></span>
                            @endif
                        </td>
                        <td style="font-weight:{{ !$contact->is_read ? '700' : '500' }}; font-size:13px;">
                            {{ $contact->name }}
                        </td>
                        <td style="font-size:12px; color:var(--text-muted);">
                            <a href="mailto:{{ $contact->email }}" style="color:inherit;">{{ $contact->email }}</a>
                        </td>
                        <td style="font-size:13px;">{{ Str::limit($contact->subject, 30) ?: '—' }}</td>
                        <td style="font-size:12px; color:var(--text-muted);">
                            {{ Str::limit($contact->message, 60) }}
                        </td>
                        <td style="font-size:12px; color:var(--text-muted); white-space:nowrap;">
                            {{ $contact->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td>
                            <span class="badge {{ $contact->is_read ? 'badge-green' : 'badge-red' }}" style="font-size:10px;">
                                {{ $contact->is_read ? "O'qilgan" : "Yangi" }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn-icon" title="Ko'rish" style="color:var(--info);">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(!$contact->is_read)
                                    <form method="POST" action="{{ route('admin.contacts.read', $contact) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn-icon" title="O'qildi deb belgilash" style="color:var(--success);">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="confirm-delete">
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
                            Xabarlar topilmadi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contacts->hasPages())
        <div style="padding:16px 20px; border-top:1px solid var(--border);">
            <div class="d-flex justify-content-between align-items-center">
                <div style="font-size:13px; color:var(--text-muted);">Jami: {{ $contacts->total() }}</div>
                <div class="pagination-wrapper" style="margin:0;">{{ $contacts->links() }}</div>
            </div>
        </div>
    @endif
</div>

@endsection
