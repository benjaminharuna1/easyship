@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')

    <ul class="nav nav-pills mb-3" id="settings-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-site" data-bs-toggle="pill" data-bs-target="#site-settings" type="button" role="tab" aria-controls="site-settings" aria-selected="true">Site Settings</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-home" data-bs-toggle="pill" data-bs-target="#homepage-content" type="button" role="tab" aria-controls="homepage-content" aria-selected="false">Homepage Content</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-email" data-bs-toggle="pill" data-bs-target="#email-settings" type="button" role="tab" aria-controls="email-settings" aria-selected="false">Email Settings</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-general" data-bs-toggle="pill" data-bs-target="#general-settings" type="button" role="tab" aria-controls="general-settings" aria-selected="false">General Settings</button>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane fade show active" id="site-settings" role="tabpanel" aria-labelledby="tab-site">
            <form method="POST" action="{{ route('admin.settings.site') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Site Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site Name</label>
                                <input type="text" class="form-control" name="site-name" value="{{ old('site-name', $settings->sitename) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site Title</label>
                                <input type="text" class="form-control" name="site-title" value="{{ old('site-title', $settings->site_title) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site URL</label>
                                <input type="url" class="form-control" name="site-url" value="{{ old('site-url', $settings->site_url) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Name (sender)</label>
                                <input type="text" class="form-control" name="email-name" value="{{ old('email-name', $settings->email_name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $settings->email_address) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Currency</label>
                                <input type="text" class="form-control" name="site_currency" value="{{ old('site_currency', $settings->site_currency) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $settings->phone_number) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fax Number</label>
                                <input type="text" class="form-control" name="fax_number" value="{{ old('fax_number', $settings->fax_number) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Working Days</label>
                                <input type="text" class="form-control" name="working_days" value="{{ old('working_days', $settings->working_days) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Working Hours</label>
                                <input type="text" class="form-control" name="working_hours" value="{{ old('working_hours', $settings->working_hours) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Geocode API Key</label>
                                <input type="text" class="form-control" name="geocode_api_key" value="{{ old('geocode_api_key', $settings->geocode_api_key) }}">
                                <small class="text-muted">LocationIQ API key used for location mapping. If you don't have one, click <a href="https://locationiq.com" target="_blank" rel="noopener">https://locationiq.com</a> to get an API access token.</small>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Site Address</label>
                                <textarea class="form-control" name="site_address" rows="3">{{ old('site_address', $settings->site_address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Images & Branding</h5>
                        <div class="row">
                            @php
                                $imageFields = [
                                    'site-logo' => ['Site Logo', 'site_logo'],
                                    'site-favicon' => ['Site Favicon', 'site_favicon'],
                                    'invoice-stamp' => ['Invoice Stamp', 'invoice_stamp'],
                                    'invoice-banner' => ['Invoice Banner', 'invoice_banner'],
                                    'payment-methods-image' => ['Payment Methods Image', 'payment_methods_image'],
                                ];
                            @endphp
                            @foreach($imageFields as $inputName => [$label, $column])
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ $label }}</label>
                                    @if($settings->{$column})
                                        <div class="mb-2">
                                            <img src="{{ asset($settings->{$column}) }}" style="max-width:200px; max-height:100px;" class="rounded border">
                                            <div class="mt-1">
                                                <input type="hidden" name="remove_{{ $column }}" id="remove_{{ $column }}" value="0">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-image-btn" data-target="remove_{{ $column }}">
                                                    <i class="bx bx-trash"></i> Mark image for removal
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" name="{{ $inputName }}" accept="image/*">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save Site Settings</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="homepage-content" role="tabpanel" aria-labelledby="tab-home">
            <form method="POST" action="{{ route('admin.settings.homepage') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Hero Section</h5>
                        <div class="mb-3">
                            <label class="form-label">Hero Subtitle</label>
                            <input type="text" class="form-control" name="hero_subtitle" value="{{ old('hero_subtitle', $settings->hero_subtitle) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hero Title</label>
                            <input type="text" class="form-control" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hero Text</label>
                            <textarea class="form-control" name="hero_text" rows="3">{{ old('hero_text', $settings->hero_text) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Video URL</label>
                            <input type="url" class="form-control" name="video_url" value="{{ old('video_url', $settings->video_url) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Video Background Image</label>
                            @if($settings->video_bg_image)
                                <div class="mb-2"><img src="{{ asset($settings->video_bg_image) }}" style="max-width:200px;" class="rounded border"></div>
                            @endif
                            <input type="file" class="form-control" name="video_bg_image" accept="image/*">
                            <input type="hidden" name="current_video_bg_image" value="{{ $settings->video_bg_image }}">
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Banners</h5>
                        <p class="text-muted">Set the banner images shown on the public pages. The Home Banner is the hero image on the home page; the Page Banner is used on the About Us, Services, Track and Contact pages.</p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Home Banner</label>
                                @if($settings->home_banner_image)
                                    <div class="mb-2">
                                        <img src="{{ asset($settings->home_banner_image) }}" style="max-width:100%; max-height:140px;" class="rounded border">
                                        <div class="mt-1">
                                            <input type="hidden" name="remove_home_banner_image" id="remove_home_banner_image" value="0">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-image-btn" data-target="remove_home_banner_image"><i class="bx bx-trash"></i> Mark image for removal</button>
                                        </div>
                                    </div>
                                @else
                                    <small class="text-muted d-block mb-2">No home banner set. The default theme banner is used.</small>
                                @endif
                                <input type="file" class="form-control" name="home_banner_image" accept="image/*">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Page Banner (About / Services / Track / Contact)</label>
                                @if($settings->page_banner_image)
                                    <div class="mb-2">
                                        <img src="{{ asset($settings->page_banner_image) }}" style="max-width:100%; max-height:140px;" class="rounded border">
                                        <div class="mt-1">
                                            <input type="hidden" name="remove_page_banner_image" id="remove_page_banner_image" value="0">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-image-btn" data-target="remove_page_banner_image"><i class="bx bx-trash"></i> Mark image for removal</button>
                                        </div>
                                    </div>
                                @else
                                    <small class="text-muted d-block mb-2">No page banner set. The default theme banner is used.</small>
                                @endif
                                <input type="file" class="form-control" name="page_banner_image" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Achievements / Counters</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Years Experience</label>
                                <input type="number" class="form-control" name="years_experience" value="{{ old('years_experience', $settings->years_experience) }}">
                            </div>
                            @for($n = 1; $n <= 4; $n++)
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Achievement {{ $n }} Number</label>
                                    <input type="number" class="form-control" name="achievement_{{ $n }}_num" value="{{ old('achievement_' . $n . '_num', $settings->{'achievement_' . $n . '_num'}) }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Achievement {{ $n }} Title</label>
                                    <input type="text" class="form-control" name="achievement_{{ $n }}_title" value="{{ old('achievement_' . $n . '_title', $settings->{'achievement_' . $n . '_title'}) }}">
                                </div>
                                @if($n == 4)
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Achievement 4 Suffix</label>
                                        <input type="text" class="form-control" name="achievement_4_suffix" value="{{ old('achievement_4_suffix', $settings->achievement_4_suffix) }}">
                                    </div>
                                @endif
                                @if($n < 4)
                                    <div class="w-100"></div>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save Homepage Content</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="email-settings" role="tabpanel" aria-labelledby="tab-email">
            <form method="POST" action="{{ route('admin.settings.email') }}" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">SMTP Configuration</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Host</label>
                                <input type="text" class="form-control" name="smtp-host" value="{{ old('smtp-host', $settings->smtp_host) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Port</label>
                                <input type="number" class="form-control" name="smtp-port" value="{{ old('smtp-port', $settings->smtp_port) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Username</label>
                                <input type="text" class="form-control" name="smtp-username" value="{{ old('smtp-username', $settings->smtp_username) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SMTP Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="smtp-password" id="smtp-password" value="{{ old('smtp-password', $settings->smtp_password) }}" autocomplete="new-password">
                                    <button type="button" class="btn btn-outline-secondary" id="toggle-smtp-password" tabindex="-1"><i class="bx bx-show"></i></button>
                                </div>
                                <small class="text-muted">Shows the current/default password. Type a new one to change it.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Encryption</label>
                                <select class="form-control" name="smtp-secure">
                                    <option value="">None</option>
                                    <option value="tls" {{ old('smtp-secure', $settings->smtp_secure) == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ old('smtp-secure', $settings->smtp_secure) == 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Email Branding</h5>
                        <p class="text-muted">These settings control how the sender and the email template look.</p>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">From Name</label>
                                <input type="text" class="form-control" name="email_name" value="{{ old('email_name', $settings->email_name) }}">
                                <small class="text-muted">Shown as the sender name on outgoing emails.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">From Email</label>
                                <input type="email" class="form-control" name="email_address" value="{{ old('email_address', $settings->email_address) }}">
                                <small class="text-muted">Reply-to / sender address shown in the email footer.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Logo</label>
                                @if($settings->site_logo)
                                    <div class="mb-2">
                                        <img src="{{ asset($settings->site_logo) }}" style="max-height:60px;" class="rounded border">
                                    </div>
                                    <small class="text-muted">Uses the site logo configured under Site Settings.</small>
                                @else
                                    <small class="text-muted">No site logo is set. Configure one under <strong>Site Settings</strong>.</small>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Primary Color</label>
                                <input type="color" class="form-control form-control-color" name="email_primary_color" value="{{ old('email_primary_color', $settings->email_primary_color ?: '#041e42') }}" style="width:60px; height:38px;">
                                <small class="text-muted">Used for the email header background and highlights.</small>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Footer Text</label>
                                <textarea class="form-control" name="email_footer_text" rows="2">{{ old('email_footer_text', $settings->email_footer_text) }}</textarea>
                                <small class="text-muted">Optional short text shown at the bottom of outgoing emails.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Test Email</h5>
                        <p class="text-muted">Send a test email to verify the SMTP settings above are working before saving.</p>
                        <div class="row align-items-end">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Recipient Email</label>
                                <input type="email" class="form-control" name="test_email" id="test-email-input" value="{{ session('test_email_value', '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <button type="button" class="btn btn-outline-primary" id="send-test-email-btn"><i class="bx bx-send me-1"></i>Send Test Email</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save Email Settings</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade" id="general-settings" role="tabpanel" aria-labelledby="tab-general">
            <form method="POST" action="{{ route('admin.settings.general') }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">General Settings</h5>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance_mode" value="1" {{ $settings->maintenance_mode ? 'checked' : '' }}>
                            <label class="form-check-label" for="maintenance_mode">Enable Maintenance Mode</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="search_engine_indexing" id="search_engine_indexing" value="1" {{ (int)($settings->search_engine_indexing ?? 1) === 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="search_engine_indexing">Allow Search Engine Indexing</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="show_contact_map" id="show_contact_map" value="1" {{ (int)($settings->show_contact_map ?? 1) === 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_contact_map">
                                Show Map on Contact Page
                                <small class="text-muted d-block" style="font-weight:400;">When on, the Google Map is visible on the public contact page. When off, it is hidden.</small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save General Settings</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    var anchor = @json(session('anchor', ''));
    if (anchor) {
        var tabBtn = document.querySelector('#settings-tabs [data-bs-target="#' + anchor + '"]');
        if (tabBtn) { new bootstrap.Tab(tabBtn).show(); }
        var el = document.getElementById(anchor);
        if (el) { el.scrollIntoView({ behavior: 'smooth' }); }
    }

    document.querySelectorAll('.remove-image-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = document.getElementById(this.getAttribute('data-target'));
            var on = input.value === '1';
            input.value = on ? '0' : '1';
            if (!on) {
                this.classList.remove('btn-outline-danger');
                this.classList.add('btn-danger');
            } else {
                this.classList.remove('btn-danger');
                this.classList.add('btn-outline-danger');
            }
        });
    });

    var smtpToggle = document.getElementById('toggle-smtp-password');
    if (smtpToggle) {
        smtpToggle.addEventListener('click', function() {
            var el = document.getElementById('smtp-password');
            var show = el.type === 'password';
            el.type = show ? 'text' : 'password';
            this.innerHTML = show ? '<i class="bx bx-hide"></i>' : '<i class="bx bx-show"></i>';
        });
    }

    var testBtn = document.getElementById('send-test-email-btn');
    if (testBtn) {
        testBtn.addEventListener('click', function() {
            var form = testBtn.closest('form');
            var recipient = new FormData(form).get('test_email');
            if (!recipient || recipient.indexOf('@') === -1) {
                alert('Please enter a recipient email address.');
                return;
            }
            var original = testBtn.innerHTML;
            testBtn.disabled = true;
            testBtn.innerHTML = '<i class="bx bx-loader bx-spin me-1"></i>Sending...';
            fetch('{{ route('admin.email.test-send') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new FormData(form)
            }).then(function(res) {
                return res.json().catch(function() {
                    return { status: res.ok ? 'success' : 'error', message: res.ok ? 'Test email sent.' : 'Your session may have expired. Please save and try again.' };
                });
            }).then(function(data) {
                if (data.status === 'success') {
                    alert(data.message);
                } else {
                    alert(data.message || 'Test email could not be sent. Check your SMTP settings and logs.');
                }
            }).catch(function() {
                alert('Test email could not be sent. Check your SMTP settings and logs.');
            }).finally(function() {
                testBtn.disabled = false;
                testBtn.innerHTML = original;
            });
        });
    }
</script>
@endpush
