<!--Start Footer One-->
<footer class="footer-one">
    <div class="footer-middle {{ isset($footerVariant) ? 'footer-middle' . $footerVariant : '' }}">
        <div class="container">
            <div class="footer-middle__inner">
                <div class="footer-logo-box">
                    <img src="{{ asset($settings->site_logo ?? '') }}" style="width: 170px;" alt="Site Logo">
                </div>
                <div class="phone-number-box {{ isset($footerVariant) ? 'phone-number-box--style2' : '' }}">
                    <div class="icon">
                        <span class="icon-phone-call-1"></span>
                    </div>
                    <div class="text">
                        <p>Need help?</p>
                        <p><a href="tel:{{ $settings->phone_number }}">{{ $settings->phone_number }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom {{ isset($footerVariant) ? 'footer-bottom' . $footerVariant : '' }}">
        <div class="container">
            <div class="footer-bottom__inner">
                <div class="copyright-text {{ isset($footerVariant) ? 'copyright-text--two' : '' }}">
                    <p>© {{ $settings->sitename }} {{ date('Y') }} | All Rights Reserved.</p>
                </div>

                <div class="copyright-menu {{ isset($footerVariant) ? 'copyright-menu--two' : '' }}">
                    <ul>
                        <li>
                            <p><a href="{{ route('terms') }}">Terms &amp; Condition</a></p>
                        </li>
                        <li>
                            <p><a href="{{ route('privacy') }}">Privacy Policy</a></p>
                        </li>
                        <li>
                            <p><a href="{{ route('contact') }}">Contact Us</a></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--End Footer One-->
