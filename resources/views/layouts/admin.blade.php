<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Boshqaruv') &mdash; Qizil Kitob Admin</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')
</head>
<body>
<div class="admin-wrapper">

    <!-- ======================== SIDEBAR ======================== -->
    <aside class="sidebar" id="sidebar">

        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <div class="sidebar-logo-icon">🌿</div>
            <div class="sidebar-logo-text">
                <div class="sidebar-logo-title">Qizil Kitob</div>
                <div class="sidebar-logo-subtitle">Admin Panel</div>
            </div>
        </a>

        <!-- Nav -->
        <nav class="sidebar-nav">

            <!-- Main -->
            <div class="sidebar-section">
                <div class="sidebar-section-label">Asosiy</div>

                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="sidebar-item-icon"><i class="bi bi-grid-1x2-fill"></i></span>
                    Boshqaruv paneli
                </a>
            </div>

            <!-- Content -->
            <div class="sidebar-section">
                <div class="sidebar-section-label">Kontent</div>

                <a href="{{ route('admin.species.index') }}"
                   class="sidebar-item {{ request()->routeIs('admin.species.*') ? 'active' : '' }}">
                    <span class="sidebar-item-icon"><i class="bi bi-bug-fill"></i></span>
                    Turlar
                    @php $speciesCount = \App\Models\Species::count(); @endphp
                    @if($speciesCount)
                        <span class="sidebar-item-badge">{{ $speciesCount }}</span>
                    @endif
                </a>

                <!-- Blog with submenu -->
                <div>
                    <div class="sidebar-item {{ request()->routeIs('admin.blog*') ? 'active' : '' }}"
                         data-bs-toggle="collapse" data-bs-target="#blogMenu" aria-expanded="{{ request()->routeIs('admin.blog*') ? 'true' : 'false' }}"
                         style="cursor:pointer;">
                        <span class="sidebar-item-icon"><i class="bi bi-journal-richtext"></i></span>
                        Blog
                        <i class="bi bi-chevron-down ms-auto" style="font-size:11px; transition:transform 0.2s;"></i>
                    </div>
                    <div class="collapse {{ request()->routeIs('admin.blog*') ? 'show' : '' }}" id="blogMenu">
                        <div class="sidebar-submenu">
                            <a href="{{ route('admin.blog.index') }}"
                               class="sidebar-item {{ request()->routeIs('admin.blog.index') || request()->routeIs('admin.blog.create') || request()->routeIs('admin.blog.edit') ? 'active' : '' }}">
                                Postlar
                            </a>
                            <a href="{{ route('admin.blog.categories.index') }}"
                               class="sidebar-item {{ request()->routeIs('admin.blog.categories.*') ? 'active' : '' }}">
                                Kategoriyalar
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.natural-resources.index') }}"
                   class="sidebar-item {{ request()->routeIs('admin.natural-resources.*') ? 'active' : '' }}">
                    <span class="sidebar-item-icon"><i class="bi bi-tree-fill"></i></span>
                    Tabiiy boyliklar
                </a>
            </div>

            <!-- Management -->
            <div class="sidebar-section">
                <div class="sidebar-section-label">Boshqaruv</div>

                <a href="{{ route('admin.contacts.index') }}"
                   class="sidebar-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <span class="sidebar-item-icon"><i class="bi bi-envelope-fill"></i></span>
                    Xabarnomalar
                    @php $unread = \App\Models\Contact::where('is_read', false)->count(); @endphp
                    @if($unread > 0)
                        <span class="sidebar-item-badge">{{ $unread }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.partners.index') }}"
                   class="sidebar-item {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                    <span class="sidebar-item-icon"><i class="bi bi-people-fill"></i></span>
                    Hamkorlar
                </a>

                @php
                    $sidebarAreas       = \App\Models\ProtectedArea::orderBy('order')->orderBy('name_uz')->get();
                    $currentCategory    = request('category');
                    $isCategoryFiltered = request()->routeIs('admin.natural-resources.index') && $currentCategory;
                    $protectedAreasOpen = request()->routeIs('admin.protected-areas.*') || $isCategoryFiltered;
                @endphp
                <div>
                    <div class="sidebar-item {{ $protectedAreasOpen ? 'active' : '' }}"
                         data-bs-toggle="collapse" data-bs-target="#protectedAreasMenu"
                         aria-expanded="{{ $protectedAreasOpen ? 'true' : 'false' }}"
                         style="cursor:pointer;">
                        <span class="sidebar-item-icon"><i class="bi bi-shield-fill"></i></span>
                        Muhofaza hududlari
                        <i class="bi bi-chevron-down ms-auto" style="font-size:11px; transition:transform 0.2s;"></i>
                    </div>
                    <div class="collapse {{ $protectedAreasOpen ? 'show' : '' }}" id="protectedAreasMenu">
                        <div class="sidebar-submenu">
                            @foreach($sidebarAreas as $area)
                                <a href="{{ route('admin.natural-resources.index', ['category' => $area->slug]) }}"
                                   class="sidebar-item {{ $currentCategory === $area->slug ? 'active' : '' }}">
                                    {{ $area->name_uz }}
                                </a>
                            @endforeach
                            <a href="{{ route('admin.protected-areas.index') }}"
                               class="sidebar-item {{ request()->routeIs('admin.protected-areas.*') ? 'active' : '' }}"
                               style="border-top:1px solid var(--border); margin-top:4px; padding-top:8px;">
                                <i class="bi bi-gear me-1"></i> Kategoriyalarni boshqarish
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.site-stats.index') }}"
                   class="sidebar-item {{ request()->routeIs('admin.site-stats.*') ? 'active' : '' }}">
                    <span class="sidebar-item-icon"><i class="bi bi-bar-chart-fill"></i></span>
                    Sayt statistikasi
                </a>

                <a href="{{ route('admin.about-page.edit') }}"
                   class="sidebar-item {{ request()->routeIs('admin.about-page.*') ? 'active' : '' }}">
                    <span class="sidebar-item-icon"><i class="bi bi-info-circle-fill"></i></span>
                    Biz haqimizda sahifasi
                </a>

                <a href="{{ route('admin.team.index') }}"
                   class="sidebar-item {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                    <span class="sidebar-item-icon"><i class="bi bi-people-fill"></i></span>
                    Bizning jamoa
                </a>
            </div>

        </nav>

        <!-- User info -->
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <div class="sidebar-user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="sidebar-user-role">Administrator</div>
                </div>
            </div>
        </div>

    </aside>
    <!-- ======================== END SIDEBAR ======================== -->

    <!-- ======================== MAIN ======================== -->
    <div class="main-content">

        <!-- Top Bar -->
        <header class="topbar">
            <button class="topbar-btn d-lg-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

            <div class="topbar-title">
                @yield('page-title', 'Boshqaruv paneli')
            </div>

            <!-- Breadcrumb -->
            <div class="topbar-breadcrumb d-none d-md-flex align-items-center">
                @yield('breadcrumb')
            </div>

            <div class="topbar-actions">
                <!-- Notifications -->
                <a href="{{ route('admin.contacts.index') }}" class="topbar-btn" title="Xabarnomalar">
                    <i class="bi bi-envelope"></i>
                    @if(isset($unread) && $unread > 0 || (\App\Models\Contact::where('is_read',false)->count() > 0))
                        <span class="badge-dot"></span>
                    @endif
                </a>

                <!-- View site -->
                <a href="/" target="_blank" class="topbar-btn" title="Saytni ko'rish">
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>

                <!-- User dropdown -->
                <div class="dropdown">
                    <button class="topbar-btn" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width:180px; border-radius:10px; border-color:var(--border);">
                        <li>
                            <div class="px-3 py-2">
                                <div style="font-weight:600; font-size:13px;">{{ Auth::user()->name ?? 'Admin' }}</div>
                                <div style="font-size:11px; color:var(--text-muted);">{{ Auth::user()->email ?? '' }}</div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="color:var(--primary); font-size:13px;">
                                    <i class="bi bi-box-arrow-right me-2"></i>Chiqish
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <div>
                &copy; {{ date('Y') }} <strong>Qizil Kitob</strong> &mdash; O'zbekiston Qizil Kitobi
            </div>
            <div>
                <span style="color:var(--secondary);">&#10022;</span>
                Laravel {{ app()->version() }}
                <span style="color:var(--secondary);">&#10022;</span>
            </div>
        </footer>

    </div>
    <!-- ======================== END MAIN ======================== -->

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Sidebar toggle for mobile
document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('open');
});

// Auto-dismiss alerts
setTimeout(function() {
    document.querySelectorAll('.alert').forEach(function(el) {
        el.style.transition = 'opacity 0.5s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
    });
}, 4000);

// Confirm delete
document.querySelectorAll('.confirm-delete').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        if (!confirm("Rostdan ham o'chirmoqchimisiz?")) {
            e.preventDefault();
        }
    });
});

// Image preview
function previewImage(input, previewId, maxMB) {
    maxMB = maxMB || 5;
    const errorId = previewId + '_error';
    const oldError = document.getElementById(errorId);
    if (oldError) oldError.remove();

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const sizeMB = file.size / (1024 * 1024);

        if (sizeMB > maxMB) {
            input.value = '';
            const preview = document.getElementById(previewId);
            if (preview) { preview.src = ''; preview.style.display = 'none'; }

            const error = document.createElement('div');
            error.id = errorId;
            error.className = 'alert alert-danger mt-2 py-2';
            error.style.fontSize = '13px';
            error.textContent = 'Rasm hajmi ' + maxMB + 'MB dan oshmasligi kerak. Tanlangan fayl: ' + sizeMB.toFixed(1) + 'MB';
            input.closest('.form-group, .card-body').appendChild(error);
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    }
}
</script>

@stack('scripts')
</body>
</html>
