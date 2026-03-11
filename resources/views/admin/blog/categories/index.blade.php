@extends('layouts.admin')

@section('title', 'Blog kategoriyalari')
@section('page-title', 'Blog kategoriyalari')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <a href="{{ route('admin.blog.index') }}">Blog</a>
    <span class="sep">/</span>
    <span>Kategoriyalar</span>
@endsection

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <h1>Blog kategoriyalari</h1>
        <p class="subtitle">Jami {{ $categories->count() }} ta kategoriya</p>
    </div>
    <a href="{{ route('admin.blog.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Postlarga qaytish
    </a>
</div>

<div class="row g-3">

    <!-- Add Form -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-plus-circle me-2"></i>Yangi kategoriya</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.blog.categories.store') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">O'zbekcha *</label>
                        <input type="text" name="title_uz" class="form-control"
                               value="{{ old('title_uz') }}" placeholder="Kategoriya nomi" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ruscha *</label>
                        <input type="text" name="title_ru" class="form-control"
                               value="{{ old('title_ru') }}" placeholder="Название категории" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Inglizcha *</label>
                        <input type="text" name="title_en" class="form-control"
                               value="{{ old('title_en') }}" placeholder="Category name" required>
                    </div>
                    <button type="submit" class="btn-primary-custom" style="width:100%;">
                        <i class="bi bi-plus-lg"></i> Qo'shish
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Categories List -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6><i class="bi bi-list me-2"></i>Kategoriyalar ro'yxati</h6>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>O'zbekcha</th>
                            <th>Ruscha</th>
                            <th>Inglizcha</th>
                            <th>Postlar</th>
                            <th>Slug</th>
                            <th style="width:80px;">Amal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td style="color:var(--text-muted); font-size:13px;">{{ $loop->iteration }}</td>
                                <td style="font-weight:600; font-size:13px;">{{ $cat->title_uz }}</td>
                                <td style="font-size:13px; color:var(--text-muted);">{{ $cat->title_ru }}</td>
                                <td style="font-size:13px; color:var(--text-muted);">{{ $cat->title_en }}</td>
                                <td>
                                    <span class="badge badge-blue">{{ $cat->posts_count }}</span>
                                </td>
                                <td>
                                    <code style="font-size:11px; color:var(--text-muted);">{{ $cat->slug }}</code>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.blog.categories.destroy', $cat) }}" class="confirm-delete">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="O'chirish">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; padding:32px; color:var(--text-muted);">
                                    Hali kategoriyalar qo'shilmagan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
