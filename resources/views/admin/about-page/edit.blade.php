@extends('layouts.admin')

@section('title', 'Biz haqimizda — Tahrirlash')
@section('page-title', 'Biz haqimizda sahifasi')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Bosh</a>
    <span class="sep">/</span>
    <span>Biz haqimizda</span>
@endsection

@section('content')

<form method="POST" action="{{ route('admin.about-page.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="page-header">
        <div class="page-header-left">
            <h1>Biz haqimizda sahifasi</h1>
            <p class="subtitle">Frontend <code>/about</code> sahifasi mazmunini tahrirlash</p>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="http://localhost:3000/about" target="_blank" class="btn-secondary-custom">
                <i class="bi bi-box-arrow-up-right"></i> Saytda ko'rish
            </a>
            <button type="submit" class="btn-primary-custom">
                <i class="bi bi-check-lg"></i> Saqlash
            </button>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle-fill"></i>
            <div>@foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach</div>
        </div>
    @endif

    {{-- ====================== HERO ====================== --}}
    <div class="card mb-3">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-image me-2"></i>1. Hero (sahifa boshlanishi)</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">🇺🇿 Sarlavha (UZ)</label>
                    <input type="text" name="hero_title_uz" class="form-control" value="{{ old('hero_title_uz', $page->hero_title_uz) }}" placeholder="Biz haqimizda">
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇷🇺 Sarlavha (RU)</label>
                    <input type="text" name="hero_title_ru" class="form-control" value="{{ old('hero_title_ru', $page->hero_title_ru) }}" placeholder="О нас">
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇬🇧 Sarlavha (EN)</label>
                    <input type="text" name="hero_title_en" class="form-control" value="{{ old('hero_title_en', $page->hero_title_en) }}" placeholder="About us">
                </div>

                <div class="col-md-4">
                    <label class="form-label">🇺🇿 Subtitle (UZ)</label>
                    <textarea name="hero_subtitle_uz" class="form-control" rows="3">{{ old('hero_subtitle_uz', $page->hero_subtitle_uz) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇷🇺 Subtitle (RU)</label>
                    <textarea name="hero_subtitle_ru" class="form-control" rows="3">{{ old('hero_subtitle_ru', $page->hero_subtitle_ru) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇬🇧 Subtitle (EN)</label>
                    <textarea name="hero_subtitle_en" class="form-control" rows="3">{{ old('hero_subtitle_en', $page->hero_subtitle_en) }}</textarea>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Hero rasm</label>
                    <input type="text" name="hero_image" class="form-control mb-2" value="{{ old('hero_image', $page->hero_image) }}" placeholder="URL yoki yuklang">
                    <input type="file" name="hero_image_file" class="form-control" accept="image/*" onchange="previewImage(this, 'hero_preview')">
                    @if($page->hero_image)
                        <img id="hero_preview" src="{{ $page->hero_image }}" style="max-height:160px;border-radius:8px;margin-top:10px;">
                    @else
                        <img id="hero_preview" src="" style="display:none;max-height:160px;border-radius:8px;margin-top:10px;">
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ====================== INTRO ====================== --}}
    <div class="card mb-3">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-card-text me-2"></i>2. Intro (asosiy matn + rasm)</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">🇺🇿 Sarlavha (UZ)</label>
                    <input type="text" name="intro_title_uz" class="form-control" value="{{ old('intro_title_uz', $page->intro_title_uz) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇷🇺 Sarlavha (RU)</label>
                    <input type="text" name="intro_title_ru" class="form-control" value="{{ old('intro_title_ru', $page->intro_title_ru) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇬🇧 Sarlavha (EN)</label>
                    <input type="text" name="intro_title_en" class="form-control" value="{{ old('intro_title_en', $page->intro_title_en) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">🇺🇿 Tavsif (UZ) <span class="text-muted">— HTML ruxsat etilgan</span></label>
                    <textarea name="intro_description_uz" class="form-control" rows="8">{{ old('intro_description_uz', $page->intro_description_uz) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇷🇺 Tavsif (RU)</label>
                    <textarea name="intro_description_ru" class="form-control" rows="8">{{ old('intro_description_ru', $page->intro_description_ru) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇬🇧 Tavsif (EN)</label>
                    <textarea name="intro_description_en" class="form-control" rows="8">{{ old('intro_description_en', $page->intro_description_en) }}</textarea>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Intro rasm</label>
                    <input type="text" name="intro_image" class="form-control mb-2" value="{{ old('intro_image', $page->intro_image) }}" placeholder="URL yoki yuklang">
                    <input type="file" name="intro_image_file" class="form-control" accept="image/*" onchange="previewImage(this, 'intro_preview')">
                    @if($page->intro_image)
                        <img id="intro_preview" src="{{ $page->intro_image }}" style="max-height:160px;border-radius:8px;margin-top:10px;">
                    @else
                        <img id="intro_preview" src="" style="display:none;max-height:160px;border-radius:8px;margin-top:10px;">
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ====================== MISSION & VISION ====================== --}}
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0"><i class="bi bi-bullseye me-2"></i>3. Missiya</h6></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">🇺🇿 Sarlavha</label>
                        <input type="text" name="mission_title_uz" class="form-control" value="{{ old('mission_title_uz', $page->mission_title_uz) }}">
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">🇷🇺 Sarlavha</label>
                        <input type="text" name="mission_title_ru" class="form-control" value="{{ old('mission_title_ru', $page->mission_title_ru) }}">
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">🇬🇧 Sarlavha</label>
                        <input type="text" name="mission_title_en" class="form-control" value="{{ old('mission_title_en', $page->mission_title_en) }}">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="form-label">🇺🇿 Matn</label>
                        <textarea name="mission_text_uz" class="form-control" rows="4">{{ old('mission_text_uz', $page->mission_text_uz) }}</textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">🇷🇺 Matn</label>
                        <textarea name="mission_text_ru" class="form-control" rows="4">{{ old('mission_text_ru', $page->mission_text_ru) }}</textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">🇬🇧 Matn</label>
                        <textarea name="mission_text_en" class="form-control" rows="4">{{ old('mission_text_en', $page->mission_text_en) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header"><h6 class="mb-0"><i class="bi bi-eye me-2"></i>4. Maqsadimiz (Vision)</h6></div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">🇺🇿 Sarlavha</label>
                        <input type="text" name="vision_title_uz" class="form-control" value="{{ old('vision_title_uz', $page->vision_title_uz) }}">
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">🇷🇺 Sarlavha</label>
                        <input type="text" name="vision_title_ru" class="form-control" value="{{ old('vision_title_ru', $page->vision_title_ru) }}">
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">🇬🇧 Sarlavha</label>
                        <input type="text" name="vision_title_en" class="form-control" value="{{ old('vision_title_en', $page->vision_title_en) }}">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="form-label">🇺🇿 Matn</label>
                        <textarea name="vision_text_uz" class="form-control" rows="4">{{ old('vision_text_uz', $page->vision_text_uz) }}</textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">🇷🇺 Matn</label>
                        <textarea name="vision_text_ru" class="form-control" rows="4">{{ old('vision_text_ru', $page->vision_text_ru) }}</textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">🇬🇧 Matn</label>
                        <textarea name="vision_text_en" class="form-control" rows="4">{{ old('vision_text_en', $page->vision_text_en) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================== GOALS ====================== --}}
    <div class="card mb-3">
        <div class="card-header">
            <h6 class="mb-0"><i class="bi bi-list-check me-2"></i>5. Maqsadlar (har qatorda bittadan)</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">🇺🇿 Sarlavha</label>
                    <input type="text" name="goals_title_uz" class="form-control" value="{{ old('goals_title_uz', $page->goals_title_uz) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇷🇺 Sarlavha</label>
                    <input type="text" name="goals_title_ru" class="form-control" value="{{ old('goals_title_ru', $page->goals_title_ru) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇬🇧 Sarlavha</label>
                    <input type="text" name="goals_title_en" class="form-control" value="{{ old('goals_title_en', $page->goals_title_en) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">🇺🇿 Maqsadlar ro'yxati</label>
                    <textarea name="goals_uz" class="form-control" rows="8" placeholder="Har qatorda bitta maqsad">{{ old('goals_uz', implode("\n", $page->goals_uz ?? [])) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇷🇺 Список целей</label>
                    <textarea name="goals_ru" class="form-control" rows="8">{{ old('goals_ru', implode("\n", $page->goals_ru ?? [])) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">🇬🇧 Goals list</label>
                    <textarea name="goals_en" class="form-control" rows="8">{{ old('goals_en', implode("\n", $page->goals_en ?? [])) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================== STATS ====================== --}}
    <div class="card mb-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="mb-0"><i class="bi bi-bar-chart-line me-2"></i>6. Sahifa statistikalari (counter blocklar)</h6>
            <button type="button" id="add-stat-btn" class="btn-secondary-custom" style="font-size:12px;padding:6px 10px;">
                <i class="bi bi-plus-lg"></i> Qator qo'shish
            </button>
        </div>
        <div class="card-body">
            <div id="stats-rows">
                @php $statsData = old('stats', $page->stats ?? []); @endphp
                @forelse($statsData as $i => $s)
                    <div class="row g-2 align-items-center mb-2 stat-row">
                        <div class="col-md-2">
                            <input type="text" name="stat_value[]" class="form-control" placeholder="700+" value="{{ $s['value'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="stat_icon[]" class="form-control" placeholder="bi-flower3" value="{{ $s['icon'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="stat_label_uz[]" class="form-control" placeholder="UZ label" value="{{ $s['label_uz'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="stat_label_ru[]" class="form-control" placeholder="RU label" value="{{ $s['label_ru'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="stat_label_en[]" class="form-control" placeholder="EN label" value="{{ $s['label_en'] ?? '' }}">
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn-icon delete remove-stat"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                @empty
                    {{-- Empty — JS qo'shadi --}}
                @endforelse
            </div>
            <small class="text-muted">Icon nomlari: <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a> dan, masalan <code>bi-tree</code>, <code>bi-shield-check</code></small>
        </div>
    </div>

    {{-- ====================== TEAM TOGGLE ====================== --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="form-check" style="display:flex;align-items:center;gap:10px;">
                <input class="form-check-input" type="checkbox" name="show_team" id="show_team" value="1" {{ old('show_team', $page->show_team) ? 'checked' : '' }}>
                <label class="form-check-label" for="show_team" style="cursor:pointer;">
                    <i class="bi bi-people me-1"></i> "Bizning jamoa" bo'limini sahifada ko'rsatish
                </label>
            </div>
        </div>
    </div>

    <div style="text-align:right;margin-bottom:30px;">
        <button type="submit" class="btn-primary-custom">
            <i class="bi bi-check-lg"></i> O'zgarishlarni saqlash
        </button>
    </div>
</form>

<template id="stat-row-template">
    <div class="row g-2 align-items-center mb-2 stat-row">
        <div class="col-md-2">
            <input type="text" name="stat_value[]" class="form-control" placeholder="700+">
        </div>
        <div class="col-md-2">
            <input type="text" name="stat_icon[]" class="form-control" placeholder="bi-flower3">
        </div>
        <div class="col-md-2">
            <input type="text" name="stat_label_uz[]" class="form-control" placeholder="UZ label">
        </div>
        <div class="col-md-2">
            <input type="text" name="stat_label_ru[]" class="form-control" placeholder="RU label">
        </div>
        <div class="col-md-2">
            <input type="text" name="stat_label_en[]" class="form-control" placeholder="EN label">
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn-icon delete remove-stat"><i class="bi bi-trash"></i></button>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
(function () {
    const container = document.getElementById('stats-rows');
    const template  = document.getElementById('stat-row-template');

    document.getElementById('add-stat-btn').addEventListener('click', () => {
        container.appendChild(template.content.cloneNode(true));
    });

    container.addEventListener('click', (e) => {
        const btn = e.target.closest('.remove-stat');
        if (btn) btn.closest('.stat-row').remove();
    });
})();
</script>
@endpush
