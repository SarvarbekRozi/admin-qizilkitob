@extends('layouts.admin')

@section('title', 'Blog postlar')
@section('page-title', 'Blog')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <span>Blog postlar</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Blog postlar</h1>
        <p class="subtitle">Barcha blog maqolalari</p>
    </div>
    <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.blog.categories.index') }}" class="btn-secondary-custom">
            <i class="bi bi-tags"></i> Kategoriyalar
        </a>
        <a href="{{ route('admin.blog.create') }}" class="btn-primary-custom">
            <i class="bi bi-plus-lg"></i> Yangi post
        </a>
    </div>
</div>

<!-- Filters -->
<div class="filters-bar">
    <form method="GET" style="display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; width:100%;">
        <div class="form-group" style="flex:1; min-width:200px;">
            <label class="form-label">Qidirish</label>
            <div style="position:relative;">
                <i class="bi bi-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:14px;"></i>
                <input type="text" name="search" class="form-control" placeholder="Sarlavha..."
                       value="{{ request('search') }}" style="padding-left:36px;">
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Kategoriya</label>
            <select name="category_id" class="form-select">
                <option value="">Barchasi</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->title_uz }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-primary-custom"><i class="bi bi-funnel"></i> Filter</button>
            @if(request()->hasAny(['search', 'category_id']))
                <a href="{{ route('admin.blog.index') }}" class="btn-secondary-custom ms-2">
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
                    <th>Sarlavha</th>
                    <th>Kategoriya</th>
                    <th>Muallif</th>
                    <th>Ko'rishlar</th>
                    <th>Sana</th>
                    <th>Status</th>
                    <th style="width:90px;">Amallar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>
                            @if($post->image)
                                <img src="{{ $post->image }}" alt="" class="table-img">
                            @else
                                <div class="table-img-placeholder">📰</div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600; font-size:13px;">{{ Str::limit($post->title_uz, 40) }}</div>
                            <div style="font-size:11px; color:var(--text-muted);">{{ Str::limit($post->title_ru, 40) }}</div>
                        </td>
                        <td>
                            @if($post->category)
                                <span class="badge badge-blue" style="font-size:10px;">{{ $post->category->title_uz }}</span>
                            @else
                                <span style="color:var(--text-muted); font-size:12px;">—</span>
                            @endif
                        </td>
                        <td style="font-size:13px;">{{ $post->author ?? '—' }}</td>
                        <td style="font-size:13px; color:var(--text-muted);">
                            <i class="bi bi-eye"></i> {{ number_format($post->views_count) }}
                        </td>
                        <td style="font-size:12px; color:var(--text-muted);">
                            {{ $post->created_at->format('d.m.Y') }}
                        </td>
                        <td>
                            <span class="badge {{ $post->is_active ? 'badge-green' : 'badge-gray' }}">
                                {{ $post->is_active ? 'Faol' : 'Nofaol' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <a href="{{ route('admin.blog.edit', $post) }}" class="btn-icon edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" class="confirm-delete">
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
                            Blog postlar topilmadi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
        <div style="padding:16px 20px; border-top:1px solid var(--border);">
            <div class="d-flex justify-content-between align-items-center">
                <div style="font-size:13px; color:var(--text-muted);">Jami: {{ $posts->total() }} ta post</div>
                <div class="pagination-wrapper" style="margin:0;">{{ $posts->links() }}</div>
            </div>
        </div>
    @endif
</div>

@endsection
