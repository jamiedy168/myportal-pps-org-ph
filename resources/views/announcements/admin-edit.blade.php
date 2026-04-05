<x-page-template bodyClass='g-sidenav-show  bg-gray-200'>
<x-auth.navbars.sidebar activePage="announcements" activeItem="announcements" activeSubitem=""></x-auth.navbars.sidebar>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
<x-auth.navbars.navs.auth pageTitle="Edit Announcement"></x-auth.navbars.navs.auth>
<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0" style="color:#1B3A6B;">Edit Announcement</h5>
                <p class="text-sm text-muted mb-0">Update details, audience, and cover photo.</p>
            </div>
            <a href="{{ route('announcements.admin') }}" class="btn btn-link text-secondary">Back to list</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="announcementEditForm" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Title <code>*</code></label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" name="title" value="{{ $announcement->title }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Subtitle</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" name="subtitle" value="{{ $announcement->subtitle }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Format <code>*</code></label>
                        <select class="form-control" name="format" required>
                            @foreach(['general'=>'General Announcement','urgent'=>'Emergency Alert','event_reminder'=>'Event Reminder','policy_update'=>'Policy Update','congratulations'=>'Congratulations'] as $key=>$label)
                                <option value="{{ $key }}" {{ $announcement->format === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Priority <code>*</code></label>
                        <select class="form-control" name="priority" required>
                            @foreach(['normal'=>'Normal','important'=>'Important','urgent'=>'Urgent'] as $key=>$label)
                                <option value="{{ $key }}" {{ $announcement->priority === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Audience <code>*</code></label>
                        @php $aud = (array)$announcement->audience; @endphp
                        <select class="form-control" name="audience[]" multiple required>
                            @foreach(['all'=>'All Users','fellow'=>'Fellows','diplomate'=>'Diplomates','in_training'=>'In Training','vip'=>'VIP Members','applicant'=>'Applicants','public'=>'Public (landing page)'] as $key=>$label)
                                <option value="{{ $key }}" {{ in_array($key,$aud) ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Select one or more. "All" overrides others.</small>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Content <code>*</code></label>
                        <div class="input-group input-group-outline">
                            <textarea class="form-control" name="content" rows="6" required>{!! $announcement->content !!}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Cover Photo (leave empty to keep existing)</label>
                        <input type="file" class="form-control" name="cover_photo" accept="image/*">
                        @if($announcement->cover_photo)
                            <small class="text-muted">Current: {{ $announcement->cover_photo }}</small>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Publish At</label>
                        <input type="datetime-local" class="form-control" name="publish_at" value="{{ optional($announcement->publish_at)->format('Y-m-d\TH:i') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Expiry Date</label>
                        <input type="datetime-local" class="form-control" name="expires_at" value="{{ optional($announcement->expires_at)->format('Y-m-d\TH:i') }}">
                    </div>

                    <div class="col-md-3 d-flex align-items-center mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_pinned" id="is_pinned" {{ $announcement->is_pinned ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_pinned">Pinned</label>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-center mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_public" id="is_public" {{ $announcement->is_public ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_public">Show on public landing</label>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn bg-gradient-primary" type="submit">Update Announcement</button>
                    <a class="btn btn-light ms-2" href="{{ route('announcements.admin') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
 </div>
</main>
<x-plugins></x-plugins>
@push('js')
<script>
    document.getElementById('announcementEditForm').addEventListener('submit', function(e){
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        fetch('{{ route('announcements.update', $announcement->id) }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if(data.success){
                window.location = '{{ route('announcements.admin') }}';
            } else {
                alert(data.message || 'Error updating announcement');
            }
        })
        .catch(() => alert('Error updating announcement'));
    });
</script>
@endpush
