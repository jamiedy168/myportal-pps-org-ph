<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="ivs-stream-manager" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-auth.navbars.navs.auth pageTitle="IVS Stream Manager"></x-auth.navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>IVS Stream Manager</h6>
                            <a href="{{ route('admin.ivs.create') }}" class="btn btn-sm bg-gradient-primary">
                                <i class="fas fa-plus"></i> Add IVS Stream
                            </a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            @if(session('success'))
                                <div class="alert alert-success mx-4 mt-3">{{ session('success') }}</div>
                            @endif
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Stream Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Button Label</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Starts At (PHT)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ends At (PHT)</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Allowed</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">State</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($streams as $stream)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-sm font-weight-bold mb-0">{{ $stream->name }}</p>
                                                <p class="text-xs text-secondary mb-0 text-truncate" style="max-width:220px;">
                                                    {{ $stream->ivs_url }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-sm mb-0">{{ $stream->button_label }}</p>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch ms-2">
                                                    <input class="form-check-input ivs-toggle" type="checkbox"
                                                        data-id="{{ $stream->id }}"
                                                        {{ $stream->status ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm mb-0">
                                                    {{ $stream->starts_at
                                                        ? $stream->starts_at->setTimezone('Asia/Manila')->format('M d, Y h:i A')
                                                        : '—' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-sm mb-0">
                                                    {{ $stream->ends_at
                                                        ? $stream->ends_at->setTimezone('Asia/Manila')->format('M d, Y h:i A')
                                                        : '—' }}
                                                </p>
                                            </td>
                                            <td>
                                                @php
                                                    $typeNames = [
                                                        2=>'Diplomate',3=>'Fellow',4=>'Emeritus',
                                                        5=>'Allied',6=>'Resident',7=>'Gov.Physician',
                                                        9=>'FIT',10=>'Active'
                                                    ];
                                                @endphp
                                                <p class="text-xs mb-0">
                                                    @if($stream->allow_admin) <span class="badge bg-gradient-dark me-1">Admin</span> @endif
                                                    @if($stream->allow_all_members) <span class="badge bg-gradient-info me-1">All Members</span> @endif
                                                    @if($stream->allow_vip) <span class="badge bg-gradient-warning text-dark me-1">VIP</span> @endif
                                                    @foreach((array)$stream->allowed_types as $typeId)
                                                        <span class="badge bg-gradient-secondary me-1">{{ $typeNames[$typeId] ?? $typeId }}</span>
                                                    @endforeach
                                                </p>
                                            </td>
                                            <td>
                                                @if($stream->isLive())
                                                    <span class="badge bg-gradient-success">🔴 LIVE</span>
                                                @elseif($stream->isComingSoon())
                                                    <span class="badge bg-gradient-warning text-dark">⏳ Coming Soon</span>
                                                @else
                                                    <span class="badge bg-gradient-secondary">Off</span>
                                                @endif
                                            </td>
                                            <td class="pe-4">
                                                <a href="{{ route('admin.ivs.edit', $stream) }}"
                                                   class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                                <form method="POST"
                                                      action="{{ route('admin.ivs.destroy', $stream) }}"
                                                      style="display:inline-block;"
                                                      onsubmit="return confirm('Delete this IVS stream?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-secondary">
                                                No IVS streams configured yet. Click "Add IVS Stream" to get started.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
    @push('js')
    <script>
        document.querySelectorAll('.ivs-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                var id = this.dataset.id;
                var checkbox = this;
                fetch('/admin/ivs/' + id + '/toggle', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (!data.success) {
                        alert('Failed to update status.');
                        checkbox.checked = !checkbox.checked;
                    }
                })
                .catch(function() {
                    alert('Network error. Please refresh and try again.');
                    checkbox.checked = !checkbox.checked;
                });
            });
        });
    </script>
    @endpush
</x-page-template>
