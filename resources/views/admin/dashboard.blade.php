@extends('layouts.admin')

@section('title', 'Boshqaruv paneli')
@section('page-title', 'Boshqaruv paneli')

@section('breadcrumb')
    <span>Bosh sahifa</span>
@endsection

@section('content')

<!-- Welcome banner -->
<div style="background: linear-gradient(135deg, var(--primary) 0%, #c44741 50%, #7a2520 100%);
            border-radius: 16px; padding: 28px 32px; margin-bottom: 28px; position: relative; overflow: hidden;">
    <div style="position:absolute;right:20px;top:50%;transform:translateY(-50%);font-size:80px;opacity:0.15;">🌿</div>
    <h2 style="color:#fff; font-family:'Playfair Display',serif; font-size:22px; margin:0 0 6px; font-weight:700;">
        Xush kelibsiz, {{ Auth::user()->name ?? 'Admin' }}!
    </h2>
    <p style="color:rgba(255,255,255,0.75); margin:0; font-size:14px;">
        Qizil Kitob boshqaruv paneli &mdash; {{ now()->format('d.m.Y') }}
    </p>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <a href="{{ route('admin.species.index') }}" class="stat-card">
            <div class="stat-icon red"><i class="bi bi-bug-fill"></i></div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['species'] }}</div>
                <div class="stat-label">Turlar</div>
                <div class="stat-change"><i class="bi bi-star-fill"></i> {{ $stats['featured_species'] }} ta featured</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="{{ route('admin.blog.index') }}" class="stat-card">
            <div class="stat-icon gold"><i class="bi bi-journal-richtext"></i></div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['blog_posts'] }}</div>
                <div class="stat-label">Blog postlar</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="{{ route('admin.natural-resources.index') }}" class="stat-card">
            <div class="stat-icon green"><i class="bi bi-tree-fill"></i></div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['resources'] }}</div>
                <div class="stat-label">Tabiiy boyliklar</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="{{ route('admin.contacts.index') }}" class="stat-card">
            <div class="stat-icon {{ $stats['unread_contacts'] > 0 ? 'red' : 'blue' }}">
                <i class="bi bi-envelope{{ $stats['unread_contacts'] > 0 ? '-fill' : '' }}"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['unread_contacts'] }}</div>
                <div class="stat-label">O'qilmagan xabar</div>
                <div class="stat-change" style="{{ $stats['unread_contacts'] > 0 ? 'color:var(--primary)' : '' }}">
                    Jami: {{ $stats['total_contacts'] }}
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Content Row -->
<div class="row g-3">

    <!-- Recent Species -->
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <h6><i class="bi bi-bug-fill me-2" style="color:var(--primary);"></i>So'nggi turlar</h6>
                <a href="{{ route('admin.species.create') }}" class="btn-primary-custom" style="padding:5px 12px; font-size:12px;">
                    <i class="bi bi-plus"></i> Qo'shish
                </a>
            </div>
            <div class="card-body" style="padding:0;">
                @if($recentSpecies->isEmpty())
                    <div style="padding:32px; text-align:center; color:var(--text-muted);">
                        <i class="bi bi-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                        Hali turlar qo'shilmagan
                    </div>
                @else
                    <table class="data-table">
                        <tbody>
                            @foreach($recentSpecies as $sp)
                                <tr>
                                    <td style="width:48px; padding:10px 8px 10px 16px;">
                                        @if($sp->image_main)
                                            <img src="{{ $sp->image_main }}" alt="" class="table-img">
                                        @else
                                            <div class="table-img-placeholder">🦋</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="font-size:13px; font-weight:600; color:var(--text-main);">
                                            {{ Str::limit($sp->name_uz, 28) }}
                                        </div>
                                        <div style="font-size:11px; font-style:italic; color:var(--text-muted);">
                                            {{ $sp->scientific_name }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $sp->danger_level_color }}" style="font-size:10px;">
                                            {{ $sp->category === 'animal' ? 'Hayvon' : 'O\'simlik' }}
                                        </span>
                                    </td>
                                    <td style="padding-right:16px;">
                                        <a href="{{ route('admin.species.edit', $sp) }}" class="btn-icon edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="padding:12px 16px; border-top:1px solid var(--border);">
                        <a href="{{ route('admin.species.index') }}" style="font-size:12px; color:var(--primary); font-weight:600;">
                            Hammasini ko'rish <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Blog Posts -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h6><i class="bi bi-journal-richtext me-2" style="color:var(--secondary-dark);"></i>Blog postlar</h6>
                <a href="{{ route('admin.blog.create') }}" class="btn-primary-custom" style="padding:5px 12px; font-size:12px;">
                    <i class="bi bi-plus"></i> Qo'shish
                </a>
            </div>
            <div class="card-body" style="padding:0;">
                @if($recentPosts->isEmpty())
                    <div style="padding:32px; text-align:center; color:var(--text-muted);">
                        <i class="bi bi-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                        Hali postlar qo'shilmagan
                    </div>
                @else
                    @foreach($recentPosts as $post)
                        <div style="padding:12px 16px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px;">
                            @if($post->image)
                                <img src="{{ $post->image }}" style="width:40px;height:40px;object-fit:cover;border-radius:6px;flex-shrink:0;" alt="">
                            @else
                                <div style="width:40px;height:40px;border-radius:6px;background:var(--body-bg);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:18px;">📰</div>
                            @endif
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ Str::limit($post->title_uz, 30) }}
                                </div>
                                <div style="font-size:11px;color:var(--text-muted);">
                                    {{ $post->category?->title_uz ?? 'Kategoriyasiz' }}
                                    &bull;
                                    {{ $post->created_at->format('d.m.Y') }}
                                </div>
                            </div>
                            <span class="badge {{ $post->is_active ? 'badge-green' : 'badge-gray' }}" style="font-size:10px;">
                                {{ $post->is_active ? 'Faol' : 'Nofaol' }}
                            </span>
                        </div>
                    @endforeach
                    <div style="padding:12px 16px;">
                        <a href="{{ route('admin.blog.index') }}" style="font-size:12px; color:var(--primary); font-weight:600;">
                            Hammasini ko'rish <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Contacts -->
    <div class="col-lg-3">
        <div class="card h-100">
            <div class="card-header">
                <h6><i class="bi bi-envelope-fill me-2" style="color:var(--primary);"></i>Xabarnomalar</h6>
                @if($stats['unread_contacts'] > 0)
                    <span class="badge badge-red">{{ $stats['unread_contacts'] }} yangi</span>
                @endif
            </div>
            <div class="card-body" style="padding:0;">
                @if($recentContacts->isEmpty())
                    <div style="padding:32px; text-align:center; color:var(--text-muted);">
                        <i class="bi bi-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                        Xabarlar yo'q
                    </div>
                @else
                    @foreach($recentContacts as $contact)
                        <a href="{{ route('admin.contacts.show', $contact) }}"
                           style="display:block; padding:12px 16px; border-bottom:1px solid var(--border); text-decoration:none; transition:background 0.15s;"
                           onmouseover="this.style.background='var(--body-bg)'" onmouseout="this.style.background=''">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                                @if(!$contact->is_read)
                                    <span class="unread-dot"></span>
                                @endif
                                <span style="font-size:13px;font-weight:{{ $contact->is_read ? '500' : '700' }};color:var(--text-main);">
                                    {{ Str::limit($contact->name, 20) }}
                                </span>
                            </div>
                            <div style="font-size:11px;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;padding-left:{{ $contact->is_read ? '0' : '14px' }};">
                                {{ Str::limit($contact->subject ?? $contact->message, 32) }}
                            </div>
                            <div style="font-size:10px;color:var(--text-muted);margin-top:3px;padding-left:{{ $contact->is_read ? '0' : '14px' }};">
                                {{ $contact->created_at->diffForHumans() }}
                            </div>
                        </a>
                    @endforeach
                    <div style="padding:12px 16px;">
                        <a href="{{ route('admin.contacts.index') }}" style="font-size:12px; color:var(--primary); font-weight:600;">
                            Hammasini ko'rish <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection
