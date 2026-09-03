<!--Start Page Header-->
<section class="page-header">
    <div class="page-header__img float-bob-y"><img src="{{ asset($settings->page_banner_image ?: 'assets/img/resource/page-header-img.png') }}" alt=""></div>
    <div class="container">
        <div class="page-header__inner">
            <h2>{{ $title }}</h2>
            <ul class="thm-breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><span class="icon-left"></span></li>
                <li>{{ $title }}</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Header-->
