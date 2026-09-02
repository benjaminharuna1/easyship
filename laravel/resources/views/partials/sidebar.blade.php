<!-- Start Extra Info -->
<div class="extra-info">
    <div class="close-icon menu-close">
        <button>
            <i class="icon-close"></i>
        </button>
    </div>
    <div class="logo-side">
        <a href="{{ route('home') }}"><img src="{{ asset($settings->site_logo ?? '') }}" alt="Logo"></a>
    </div>
    <div class="side-info">
        <div class="content-box">
            <h3>Welcome to our Best<br> Transportation Company</h3>
            <div class="text">
                <p>It is a long established fact that a reader will be distracted by the content of a page when looking at its layout.</p>
            </div>
        </div>
        <div class="sidebar-contact-info">
            <h3>Contact Us</h3>
            <ul>
                <li>
                    <div class="icon">
                        <span class="icon-open-mail"></span>
                    </div>
                    <div class="text">
                        <p><a href="mailto:{{ $settings->email_address }}">{{ $settings->email_address }}</a></p>
                    </div>
                </li>
                <li>
                    <div class="icon">
                        <span class="icon-phone-call-1"></span>
                    </div>
                    <div class="text">
                        <p><a href="tel:{{ $settings->phone_number }}">{{ $settings->phone_number }}</a></p>
                    </div>
                </li>
                <li>
                    <div class="icon">
                        <span class="fa-regular fa-clock"></span>
                    </div>
                    <div class="text">
                        <p>{{ $settings->working_days }} : {{ $settings->working_hours }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="offcanvas-overly"></div>
<!-- End Extra Info -->
