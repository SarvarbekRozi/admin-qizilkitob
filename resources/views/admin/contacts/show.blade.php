@extends('layouts.admin')

@section('title', 'Xabar')
@section('page-title', 'Xabar tafsilotlari')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.contacts.index') }}">Xabarnomalar</a>
    <span class="sep">/</span>
    <span>Ko'rish</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>{{ $contact->name }}</h1>
        <p class="subtitle">{{ $contact->created_at->format('d.m.Y H:i') }}</p>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.contacts.index') }}" class="btn-secondary-custom">
            <i class="bi bi-arrow-left"></i> Orqaga
        </a>
        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="confirm-delete">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger-custom">
                <i class="bi bi-trash"></i> O'chirish
            </button>
        </form>
    </div>
</div>

<div class="row g-3">

    <!-- Message -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-envelope me-2"></i>Xabar matni</h6>
                <span class="badge {{ $contact->is_read ? 'badge-green' : 'badge-red' }}">
                    {{ $contact->is_read ? "O'qilgan" : "Yangi" }}
                </span>
            </div>
            <div class="card-body">
                @if($contact->subject)
                    <div style="margin-bottom:16px; padding:12px 16px; background:var(--body-bg); border-radius:8px; border-left:3px solid var(--primary);">
                        <div class="detail-label">Mavzu</div>
                        <div class="detail-value" style="font-size:16px; font-weight:600;">{{ $contact->subject }}</div>
                    </div>
                @endif
                <div style="font-size:15px; line-height:1.7; color:var(--text-main); white-space:pre-line;">{{ $contact->message }}</div>
            </div>
        </div>
    </div>

    <!-- Sender Info -->
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6><i class="bi bi-person me-2"></i>Jo'natuvchi</h6>
            </div>
            <div class="card-body">
                <div style="display:flex; flex-direction:column; gap:16px;">
                    <div>
                        <div class="detail-label">Ismi</div>
                        <div class="detail-value" style="font-size:16px; font-weight:600;">{{ $contact->name }}</div>
                    </div>
                    <div>
                        <div class="detail-label">Email</div>
                        <div class="detail-value">
                            <a href="mailto:{{ $contact->email }}" style="color:var(--primary); font-weight:600;">
                                {{ $contact->email }}
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="detail-label">Yuborilgan vaqt</div>
                        <div class="detail-value">{{ $contact->created_at->format('d.m.Y H:i:s') }}</div>
                        <div style="font-size:11px; color:var(--text-muted);">{{ $contact->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-lightning me-2"></i>Amallar</h6>
            </div>
            <div class="card-body" style="display:flex; flex-direction:column; gap:10px;">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}"
                   class="btn-primary-custom" style="justify-content:center;">
                    <i class="bi bi-reply"></i> Javob yozish
                </a>
                @if(!$contact->is_read)
                    <form method="POST" action="{{ route('admin.contacts.read', $contact) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-secondary-custom" style="width:100%; justify-content:center;">
                            <i class="bi bi-check-circle"></i> O'qildi deb belgilash
                        </button>
                    </form>
                @endif
                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="confirm-delete">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger-custom" style="width:100%; justify-content:center;">
                        <i class="bi bi-trash"></i> O'chirish
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
