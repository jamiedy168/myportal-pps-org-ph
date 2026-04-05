<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="ivs-stream-manager" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-auth.navbars.navs.auth pageTitle="{{ $stream ? 'Edit IVS Stream' : 'Add IVS Stream' }}"></x-auth.navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>{{ $stream ? 'Edit: ' . $stream->name : 'New IVS Stream' }}</h6>
                        </div>
                        <div class="card-body">
                            @php
                                $startsAtValue = '';
                                $endsAtValue   = '';
                                if ($stream && $stream->starts_at) {
                                    $startsAtValue = $stream->starts_at->setTimezone('Asia/Manila')->format('Y-m-d')
                                        . 'T'
                                        . $stream->starts_at->setTimezone('Asia/Manila')->format('H:i');
                                }
                                if ($stream && $stream->ends_at) {
                                    $endsAtValue = $stream->ends_at->setTimezone('Asia/Manila')->format('Y-m-d')
                                        . 'T'
                                        . $stream->ends_at->setTimezone('Asia/Manila')->format('H:i');
                                }
                                $allowedTypesOld = old('allowed_types', $stream->allowed_types ?? []);
                            @endphp
                            <form method="POST"
                                  action="{{ $stream ? route('admin.ivs.update', $stream) : route('admin.ivs.store') }}">
                                @csrf
                                @if($stream)
                                    @method('PUT')
                                @endif

                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label text-dark font-weight-bold">Stream Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                           value="{{ old('name', $stream->name ?? '') }}"
                                           required
                                           placeholder="e.g. 63rd Annual Convention — Plenary">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-dark font-weight-bold">Button Label <span class="text-danger">*</span></label>
                                    <input type="text" name="button_label" class="form-control"
                                           value="{{ old('button_label', $stream->button_label ?? 'Watch Now') }}"
                                           required
                                           placeholder="e.g. Watch Now, Join Live, View Stream">
                                    <div class="text-xs text-secondary mt-1">This text appears on the button members click to watch.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-dark font-weight-bold">IVS Playback URL <span class="text-danger">*</span></label>
                                    <input type="text" name="ivs_url" class="form-control"
                                           value="{{ old('ivs_url', $stream->ivs_url ?? '') }}"
                                           required
                                           placeholder="https://xxxx.us-east-1.playback.live-video.net/api/video/v1/....m3u8"
                                           style="font-family:monospace; font-size:13px;">
                                    <div class="text-xs text-secondary mt-1">Paste the .m3u8 playback URL from your AWS IVS channel.</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-dark font-weight-bold">Starts At — PHT (optional)</label>
                                        <input type="datetime-local" name="starts_at" class="form-control"
                                               value="{{ old('starts_at', $startsAtValue) }}">
                                        <div class="text-xs text-secondary mt-1">Leave blank to go live immediately when status is ON.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-dark font-weight-bold">Ends At — PHT (optional)</label>
                                        <input type="datetime-local" name="ends_at" class="form-control"
                                               value="{{ old('ends_at', $endsAtValue) }}">
                                        <div class="text-xs text-secondary mt-1">Leave blank to keep live until manually turned off.</div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" id="statusToggle"
                                               {{ old('status', $stream->status ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark font-weight-bold" for="statusToggle">Active (Manual ON/OFF)</label>
                                    </div>
                                    <div class="text-xs text-secondary mt-1">Stream is only live when this is ON AND current time is within the schedule above.</div>
                                </div>

                                <hr>
                                <h6 class="text-dark mb-3">Who Can Watch This Stream?</h6>

                                <div class="mb-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="allow_admin" id="allowAdmin"
                                               {{ old('allow_admin', $stream->allow_admin ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark" for="allowAdmin"><strong>Admin</strong></label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="allow_all_members" id="allowAll"
                                               {{ old('allow_all_members', $stream->allow_all_members ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark" for="allowAll"><strong>All Members</strong> — any member type</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="allow_vip" id="allowVip"
                                               {{ old('allow_vip', $stream->allow_vip ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark" for="allowVip"><strong>VIP Members</strong></label>
                                    </div>
                                </div>

                                <label class="form-label text-dark font-weight-bold">Specific Member Types:</label>
                                <div class="row mb-4">
                                    @foreach($memberTypes as $typeId => $typeName)
                                    <div class="col-md-4 col-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="allowed_types[]"
                                                   value="{{ $typeId }}"
                                                   id="type_{{ $typeId }}"
                                                   {{ in_array($typeId, $allowedTypesOld) ? 'checked' : '' }}>
                                            <label class="form-check-label text-dark" for="type_{{ $typeId }}">{{ $typeName }}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        {{ $stream ? 'Update Stream' : 'Create Stream' }}
                                    </button>
                                    <a href="{{ route('admin.ivs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-page-template>