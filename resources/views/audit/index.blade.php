<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="audit-trails" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-auth.navbars.navs.auth pageTitle="Audit Trails"></x-auth.navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Recent Changes</h6>
                    <span class="text-xs text-secondary">showing latest {{ $audits->count() }} of {{ $audits->total() }}</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">When</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Event</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Model</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Target ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">IP</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User Agent</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">URL</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Changed Fields</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($audits as $audit)
                                <tr>
                                    <td class="text-sm mb-0">{{ optional($audit->created_at)->timezone('Asia/Manila')->format('Y-m-d H:i:s') }}</td>
                                    <td class="text-sm">
                                        {{ $audit->user->name ?? 'System' }}
                                        <div class="text-xxs text-secondary">{{ $audit->user->email ?? '' }}</div>
                                    </td>
                                    <td class="text-sm">{{ strtoupper($audit->event) }}</td>
                                    <td class="text-sm">{{ class_basename($audit->auditable_type) }}</td>
                                    <td class="text-sm">{{ $audit->auditable_id }}</td>
                                    <td class="text-sm">{{ $audit->ip_address }}</td>
                                    <td class="text-xs" style="max-width: 200px; word-break: break-all;">{{ $audit->user_agent }}</td>
                                    <td class="text-xs" style="max-width: 200px; word-break: break-all;">{{ $audit->url }}</td>
                                    <td class="text-xs">
                                        @php
                                            $changedKeys = collect($audit->new_values ?? [])->keys()->implode(', ');
                                        @endphp
                                        {{ $changedKeys ?: 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center text-secondary">No audit records yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    {{ $audits->links() }}
                </div>
            </div>
            <x-auth.footers.auth.footer></x-auth.footers.auth.footer>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-page-template>
