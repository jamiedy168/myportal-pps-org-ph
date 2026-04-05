<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
<x-auth.navbars.sidebar activePage="announcements" activeItem="announcements" activeSubitem=""></x-auth.navbars.sidebar>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
<x-auth.navbars.navs.auth pageTitle="New Announcement"></x-auth.navbars.navs.auth>

<div class="container-fluid py-4">

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius:14px;">
                <div class="card-header pb-0 pt-3 px-4"
                     style="background:linear-gradient(135deg,#1B3A6B,#2E75B6);border-radius:14px 14px 0 0;">
                    <h5 class="text-white mb-0 fw-bold">
                        <i class="material-icons align-middle me-2">campaign</i>
                        Create New Announcement
                    </h5>
                    <p class="text-white-50 text-sm mb-2">
                        Fill in the details below. All fields marked * are required.
                    </p>
                </div>
                <div class="card-body px-4 pt-4">

                    <form id="announcementCreateForm" enctype="multipart/form-data">
                        @csrf

                        {{-- TITLE --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-sm" style="color:#1B3A6B;">
                                    Title *
                                </label>
                                <div class="input-group input-group-outline">
                                    <input type="text"
                                           name="title"
                                           class="form-control"
                                           placeholder="Announcement title"
                                           required
                                           maxlength="255">
                                </div>
                            </div>
                        </div>

                        {{-- SUBTITLE --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-sm" style="color:#1B3A6B;">
                                    Subtitle <span class="text-muted fw-normal">(optional)</span>
                                </label>
                                <div class="input-group input-group-outline">
                                    <input type="text"
                                           name="subtitle"
                                           class="form-control"
                                           placeholder="Short description shown under the title"
                                           maxlength="255">
                                </div>
                            </div>
                        </div>

                        {{-- FORMAT --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-sm" style="color:#1B3A6B;">
                                    Format / Type *
                                </label>
                                <div class="d-flex flex-wrap gap-2 mt-1">
                                    @foreach([
                                        ['value' => 'general',          'label' => 'General',          'icon' => 'campaign',      'color' => '#1B3A6B'],
                                        ['value' => 'urgent',           'label' => 'Emergency Alert',  'icon' => 'warning',       'color' => '#DC3545'],
                                        ['value' => 'event_reminder',   'label' => 'Event Reminder',   'icon' => 'event',         'color' => '#1a7a4a'],
                                        ['value' => 'policy_update',    'label' => 'Policy Update',    'icon' => 'policy',        'color' => '#2E75B6'],
                                        ['value' => 'congratulations',  'label' => 'Congratulations',  'icon' => 'celebration',   'color' => '#C9A84C'],
                                    ] as $fmt)
                                    <label class="format-card"
                                           style="cursor:pointer;border:2px solid #e0e0e0;border-radius:10px;padding:10px 14px;min-width:130px;text-align:center;transition:all 0.2s;">
                                        <input type="radio"
                                               name="format"
                                               value="{{ $fmt['value'] }}"
                                               class="d-none format-radio"
                                               {{ $fmt['value'] === 'general' ? 'checked' : '' }}>
                                        <i class="material-icons d-block mb-1"
                                           style="font-size:28px;color:{{ $fmt['color'] }};">
                                            {{ $fmt['icon'] }}
                                        </i>
                                        <span style="font-size:12px;font-weight:600;color:#2C2C2C;">
                                            {{ $fmt['label'] }}
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- PRIORITY --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-sm" style="color:#1B3A6B;">
                                    Priority *
                                </label>
                                <div class="input-group input-group-outline">
                                    <select name="priority" class="form-control" required>
                                        <option value="normal">Normal</option>
                                        <option value="important">Important</option>
                                        <option value="urgent">Urgent</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- CONTENT --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-sm" style="color:#1B3A6B;">
                                    Content * <span class="text-muted fw-normal">(HTML supported)</span>
                                </label>
                                <textarea name="content"
                                          class="form-control"
                                          rows="8"
                                          placeholder="Type your announcement content here. You may use basic HTML tags like <b>, <ul>, <li>, <p>, <a>."
                                          required
                                          style="border:1px solid #d0d0d0;border-radius:8px;padding:12px;font-size:14px;"></textarea>
                            </div>
                        </div>

                        {{-- COVER PHOTO --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-sm" style="color:#1B3A6B;">
                                    Cover Photo <span class="text-muted fw-normal">(recommended: 1400x700px)</span>
                                </label>
                                <input type="file"
                                       name="cover_photo"
                                       class="form-control"
                                       accept="image/*"
                                       id="coverPhotoInput">
                                <div id="coverPreview" class="mt-2" style="display:none;">
                                    <img id="coverPreviewImg"
                                         style="max-height:180px;border-radius:10px;border:2px solid #1B3A6B;">
                                </div>
                            </div>
                        </div>

                        {{-- AUDIENCE --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold text-sm" style="color:#1B3A6B;">
                                    Who can see this? *
                                </label>
                                <div class="row mt-1">
                                    @foreach([
                                        ['value' => 'all',        'label' => 'All Users',       'desc' => 'Everyone logged in'],
                                        ['value' => 'fellow',     'label' => 'Fellows',          'desc' => 'Fellow members only'],
                                        ['value' => 'diplomate',  'label' => 'Diplomates',       'desc' => 'Diplomate members only'],
                                        ['value' => 'in_training','label' => 'In Training',      'desc' => 'Residents & trainees'],
                                        ['value' => 'vip',        'label' => 'VIP Members',      'desc' => 'BOT, Past Presidents, etc.'],
                                        ['value' => 'applicant',  'label' => 'Applicants',       'desc' => 'Pending applications'],
                                        ['value' => 'public',     'label' => 'Public',           'desc' => 'No login required'],
                                    ] as $aud)
                                    <div class="col-md-4 col-6 mb-2">
                                        <label class="d-flex align-items-start gap-2"
                                               style="cursor:pointer;padding:8px;border:1px solid #e0e0e0;border-radius:8px;">
                                            <input type="checkbox"
                                                   name="audience[]"
                                                   value="{{ $aud['value'] }}"
                                                   class="audience-checkbox mt-1"
                                                   {{ $aud['value'] === 'all' ? 'checked' : '' }}>
                                            <div>
                                                <div style="font-size:13px;font-weight:600;color:#1B3A6B;">
                                                    {{ $aud['label'] }}
                                                </div>
                                                <div style="font-size:11px;color:#888;">
                                                    {{ $aud['desc'] }}
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- OPTIONS ROW --}}
                        <div class="row mb-3">
                            <div class="col-md-4 mb-2">
                                <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                    <input type="checkbox" name="is_pinned" value="1" class="form-check-input mt-0">
                                    <div>
                                        <div style="font-size:13px;font-weight:600;color:#1B3A6B;">
                                            ?? Pin Announcement
                                        </div>
                                        <div style="font-size:11px;color:#888;">Show at top always</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="d-flex align-items-center gap-2" style="cursor:pointer;">
                                    <input type="checkbox" name="is_public" value="1" class="form-check-input mt-0">
                                    <div>
                                        <div style="font-size:13px;font-weight:600;color:#1B3A6B;">
                                            ?? Show on Landing Page
                                        </div>
                                        <div style="font-size:11px;color:#888;">No login required</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- DATES ROW --}}
                        <div class="row mb-4">
                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-bold text-sm" style="color:#1B3A6B;">
                                    Publish Date <span class="text-muted fw-normal">(leave blank = publish now)</span>
                                </label>
                                <div class="input-group input-group-outline">
                                    <input type="datetime-local" name="publish_at" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label fw-bold text-sm" style="color:#1B3A6B;">
                                    Expiry Date <span class="text-muted fw-normal">(auto-archive after this date)</span>
                                </label>
                                <div class="input-group input-group-outline">
                                    <input type="datetime-local" name="expires_at" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex gap-3 pb-2">
                            <button type="submit"
                                    id="submitBtn"
                                    class="btn btn-lg flex-fill"
                                    style="background:#800000;color:#fff;border-radius:10px;font-weight:700;">
                                <i class="material-icons align-middle me-2">send</i>
                                Publish Announcement
                            </button>
                            <a href="{{ route('announcements.admin') }}"
                               class="btn btn-lg"
                               style="border:2px solid #1B3A6B;color:#1B3A6B;border-radius:10px;min-width:120px;">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
</main>
<x-plugins></x-plugins>

@push('js')
<script>
// Cover photo preview
document.getElementById('coverPhotoInput').addEventListener('change', function() {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('coverPreviewImg').src = e.target.result;
            document.getElementById('coverPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Format card visual selection
document.querySelectorAll('.format-radio').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.format-card').forEach(function(card) {
            card.style.border = '2px solid #e0e0e0';
            card.style.background = '#fff';
        });
        if (this.checked) {
            this.closest('.format-card').style.border = '2px solid #800000';
            this.closest('.format-card').style.background = '#fff5f5';
        }
    });
    if (radio.checked) {
        radio.closest('.format-card').style.border = '2px solid #800000';
        radio.closest('.format-card').style.background = '#fff5f5';
    }
});

var allCheckbox = document.querySelector('input[value="all"].audience-checkbox');
var otherCheckboxes = document.querySelectorAll('.audience-checkbox:not([value="all"])');
if (allCheckbox) {
    allCheckbox.addEventListener('change', function() {
        otherCheckboxes.forEach(function(cb) {
            cb.disabled = allCheckbox.checked;
            if (allCheckbox.checked) cb.checked = false;
        });
    });
}

document.getElementById('announcementCreateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="material-icons align-middle me-2">hourglass_empty</i> Publishing...';

    var formData = new FormData(this);

    fetch('/announcements-store', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            window.location.href = '/announcements-admin';
        } else {
            alert(data.message || 'Error saving announcement. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="material-icons align-middle me-2">send</i> Publish Announcement';
        }
    })
    .catch(function() {
        alert('Network error. Please check your connection and try again.');
        btn.disabled = false;
        btn.innerHTML = '<i class="material-icons align-middle me-2">send</i> Publish Announcement';
    });
});
</script>
@endpush

</x-page-template>
