<x-page-template bodyClass='g-sidenav-show bg-gray-200'>
    <x-auth.navbars.sidebar activePage="maintenance" activeItem="payment-gateway" activeSubitem=""></x-auth.navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-auth.navbars.navs.auth pageTitle="Payment Gateway"></x-auth.navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">PayMongo Configuration</h5>
                                <span class="badge bg-{{ ($mode ?? 'test') === 'live' ? 'success' : 'secondary' }} text-uppercase">
                                    Mode: {{ strtoupper($mode ?? 'test') }}
                                </span>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success text-white">{{ session('status') }}</div>
                            @endif
                            <form method="POST" action="{{ route('payment-gateway.update') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Mode</label>
                                        <select class="form-control" name="mode">
                                            <option value="test" {{ ($setting->mode ?? 'test') === 'test' ? 'selected' : '' }}>Sandbox / Test</option>
                                            <option value="live" {{ ($setting->mode ?? '') === 'live' ? 'selected' : '' }}>Production / Live</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Test API Key (Base64)</label>
                                        <input type="text" class="form-control" name="test_key" value="{{ $setting->test_key ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Live API Key (Base64)</label>
                                        <input type="text" class="form-control" name="live_key" value="{{ $setting->live_key ?? '' }}">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Test Webhook Secret</label>
                                        <input type="text" class="form-control" name="test_webhook_secret" value="{{ $setting->test_webhook_secret ?? '' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Live Webhook Secret</label>
                                        <input type="text" class="form-control" name="live_webhook_secret" value="{{ $setting->live_webhook_secret ?? '' }}">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button class="btn btn-danger" type="submit">Save Settings</button>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <p class="text-sm">
                                    Best practices:
                                    <ul>
                                        <li>Use separate keys and webhook secrets for Sandbox and Production.</li>
                                        <li>Restrict webhook URL by IP or signature (already enforced) and keep secrets out of chat/email.</li>
                                        <li>Rotate keys periodically; update here and in PayMongo dashboard together.</li>
                                        <li>Future gateways (Maya, GCash, etc.) can be added with the same pattern: store per-mode keys and secrets.</li>
                                    </ul>
                                </p>
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
