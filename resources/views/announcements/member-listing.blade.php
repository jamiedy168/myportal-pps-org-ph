@php use Illuminate\Support\Str; @endphp
<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
<x-auth.navbars.sidebar activePage="announcements" activeItem="announcements" activeSubitem=""></x-auth.navbars.sidebar>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
<x-auth.navbars.navs.auth pageTitle="Announcements"></x-auth.navbars.navs.auth>

<div class="container-fluid py-4">

    @forelse($announcements as $ann)
    <div class="card shadow-sm border-0 mb-4"
         style="border-radius:14px;overflow:hidden;border-left:5px solid {{ $ann->priority_color }} !important;">

        {{-- Priority Header --}}
        <div class="px-4 py-2 d-flex justify-content-between align-items-center"
             style="background:{{ $ann->priority_color }};">
            <span style="color:#fff;font-weight:700;font-size:13px;letter-spacing:1px;">
                {{ $ann->priority_label }}
            </span>
            <span style="color:rgba(255,255,255,0.85);font-size:12px;font-style:italic;">
                {{ $ann->format_label }}
                @if($ann->is_pinned)
                &nbsp;?? Pinned
                @endif
            </span>
        </div>

        {{-- Cover Photo --}}
        @if($ann->cover_photo)
        <div style="max-height:320px;overflow:hidden;">
            <img src="{{ $ann->cover_photo_url }}"
                 alt="{{ $ann->title }}"
                 style="width:100%;object-fit:cover;"
                 onerror="this.style.display='none'">
        </div>
        @endif

        {{-- Content --}}
        <div class="card-body px-4 py-3">
            <h4 class="fw-bold mb-1" style="color:#1B3A6B;">{{ $ann->title }}</h4>

            @if($ann->subtitle)
            <p class="text-muted mb-3" style="font-size:15px;">{{ $ann->subtitle }}</p>
            @endif

            <hr class="my-3">

            <div class="announcement-content" style="font-size:15px;line-height:1.8;color:#2C2C2C;">
                {!! $ann->content !!}
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3"
                 style="border-top:1px solid #f0f0f0;">
                <div>
                    @foreach((array)$ann->audience as $aud)
                    <span class="badge me-1"
                          style="background:#1B3A6B15;color:#1B3A6B;font-size:11px;border-radius:20px;padding:4px 10px;">
                        {{ ucfirst($aud) }}
                    </span>
                    @endforeach
                </div>
                <small class="text-muted mt-2 mt-md-0">
                    <i class="material-icons align-middle" style="font-size:13px;">calendar_today</i>
                    {{ $ann->created_at->format('F d, Y') }}
                    @if($ann->expires_at)
                    &nbsp;·&nbsp;
                    <i class="material-icons align-middle" style="font-size:13px;">timer</i>
                    Until {{ $ann->expires_at->format('M d, Y') }}
                    @endif
                </small>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-5">
        <i class="material-icons" style="font-size:72px;color:#ddd;">campaign</i>
        <h5 class="text-muted mt-3">No announcements at this time.</h5>
        <p class="text-muted">Check back later for updates from the Philippine Pediatric Society.</p>
    </div>
    @endforelse

</div>
</main>
<x-plugins></x-plugins>
</x-page-template>
