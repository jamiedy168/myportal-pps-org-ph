@php use Illuminate\Support\Str; @endphp
<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
<x-auth.navbars.sidebar activePage="announcements" activeItem="announcements" activeSubitem=""></x-auth.navbars.sidebar>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
<x-auth.navbars.navs.auth pageTitle="Announcements Manager"></x-auth.navbars.navs.auth>

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-0 font-weight-bold" style="color:#1B3A6B;">
                    <i class="material-icons align-middle me-2">campaign</i>
                    Announcements Manager
                </h4>
                <p class="text-sm text-muted mb-0">
                    Create and manage announcements for members and the public landing page.
                </p>
            </div>
            @if(auth()->user()->role_id == 1)
            <a href="{{ route('announcements.create') }}"
               class="btn btn-sm"
               style="background:#800000;color:#fff;border-radius:8px;padding:10px 20px;">
                <i class="material-icons align-middle me-1" style="font-size:18px;">add</i>
                New Announcement
            </a>
            @endif
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width:48px;height:48px;background:#1B3A6B20;">
                        <i class="material-icons" style="color:#1B3A6B;font-size:24px;">campaign</i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color:#1B3A6B;">
                            {{ $announcements->where('is_active', true)->count() }}
                        </h5>
                        <small class="text-muted">Active</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width:48px;height:48px;background:#80000020;">
                        <i class="material-icons" style="color:#800000;font-size:24px;">push_pin</i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color:#800000;">
                            {{ $announcements->where('is_pinned', true)->count() }}
                        </h5>
                        <small class="text-muted">Pinned</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width:48px;height:48px;background:#6c757d20;">
                        <i class="material-icons" style="color:#6c757d;font-size:24px;">archive</i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color:#6c757d;">
                            {{ $announcements->where('is_active', false)->count() }}
                        </h5>
                        <small class="text-muted">Archived</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Announcement Cards --}}
    <div class="row">
        @forelse($announcements as $ann)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100"
                 style="border-radius:14px;overflow:hidden;border-left:4px solid {{ $ann->priority_color }} !important;">

                {{-- Cover Photo --}}
                <div style="height:180px;overflow:hidden;position:relative;">
                    <img src="{{ $ann->cover_photo_url }}"
                         alt="{{ $ann->title }}"
                         style="width:100%;height:100%;object-fit:cover;"
                         onerror="this.src='{{ asset('assets/img/illustrations/pps-logo.png') }}'">

                    <span class="position-absolute top-0 start-0 m-2 badge"
                          style="background:{{ $ann->priority_color }};font-size:11px;padding:6px 10px;border-radius:20px;">
                        {{ $ann->priority_label }}
                    </span>

                    <span class="position-absolute top-0 end-0 m-2 badge bg-dark"
                          style="font-size:10px;border-radius:20px;opacity:0.85;">
                        {{ $ann->format_label }}
                    </span>

                    @if(!$ann->is_active)
                    <div class="position-absolute bottom-0 start-0 end-0 text-center py-1"
                         style="background:rgba(0,0,0,0.6);">
                        <span class="text-white" style="font-size:11px;">
                            <i class="material-icons align-middle" style="font-size:13px;">archive</i>
                            ARCHIVED
                            @if($ann->archived_at)
                                {{ $ann->archived_at->format('M d, Y') }}
                            @endif
                        </span>
                    </div>
                    @endif

                    @if($ann->is_pinned)
                    <span class="position-absolute"
                          style="top:8px;left:50%;transform:translateX(-50%);">
                        <i class="material-icons"
                           style="color:#C9A84C;font-size:20px;text-shadow:0 1px 3px rgba(0,0,0,0.5);">
                            push_pin
                        </i>
                    </span>
                    @endif
                </div>

                {{-- Card Body --}}
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-1" style="color:#1B3A6B;font-size:15px;line-height:1.3;">
                        {{ Str::limit($ann->title, 60) }}
                    </h6>

                    @if($ann->subtitle)
                    <p class="text-muted mb-2" style="font-size:12px;">
                        {{ Str::limit($ann->subtitle, 80) }}
                    </p>
                    @endif

                    <div class="mb-2">
                        @foreach((array)$ann->audience as $aud)
                        <span class="badge me-1"
                              style="background:#1B3A6B15;color:#1B3A6B;font-size:10px;border-radius:20px;padding:3px 8px;">
                            {{ ucfirst($aud) }}
                        </span>
                        @endforeach

                        @if($ann->is_public)
                        <span class="badge"
                              style="background:#1a7a4a20;color:#1a7a4a;font-size:10px;border-radius:20px;padding:3px 8px;">
                            Public
                        </span>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            <i class="material-icons align-middle" style="font-size:12px;">person</i>
                            {{ optional($ann->creator)->name ?? 'System' }}
                        </small>
                        <small class="text-muted">
                            {{ $ann->created_at->format('M d, Y') }}
                        </small>
                    </div>

                    @if($ann->expires_at)
                    <small class="text-warning d-block mt-1">
                        <i class="material-icons align-middle" style="font-size:12px;">timer</i>
                        Expires {{ $ann->expires_at->format('M d, Y') }}
                    </small>
                    @endif
                </div>

                {{-- Card Footer --}}
                @if(auth()->user()->role_id == 1)
                <div class="card-footer bg-transparent border-top-0 pt-0 pb-3 px-3">
                    <div class="d-flex gap-2">
                        <a href="{{ route('announcements.edit', $ann->id) }}"
                           class="btn btn-sm flex-fill"
                           style="border:1px solid #1B3A6B;color:#1B3A6B;border-radius:8px;font-size:12px;">
                            <i class="material-icons align-middle" style="font-size:14px;">edit</i>
                            Edit
                        </a>
                        @if($ann->is_active)
                        <button class="btn btn-sm flex-fill btn-archive-ann"
                                data-id="{{ $ann->id }}"
                                style="border:1px solid #dc3545;color:#dc3545;border-radius:8px;font-size:12px;">
                            <i class="material-icons align-middle" style="font-size:14px;">archive</i>
                            Archive
                        </button>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="material-icons" style="font-size:64px;color:#ccc;">campaign</i>
            <p class="text-muted mt-2">No announcements yet. Create your first one above.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $announcements->links('vendor.pagination.bootstrap-5') }}
    </div>

</div>
</main>
<x-plugins></x-plugins>

@push('js')
<script>
document.querySelectorAll('.btn-archive-ann').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var id = this.dataset.id;
        if (!confirm('Archive this announcement? It will no longer be visible to members.')) return;
        fetch('/announcements-archive/' + id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ reason: 'Manually archived by admin' })
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) { location.reload(); }
            else { alert('Error archiving announcement.'); }
        });
    });
});
</script>
@endpush

</x-page-template>
