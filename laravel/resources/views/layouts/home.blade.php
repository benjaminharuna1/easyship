@extends('layouts.base')

@section('content_wrapper')
    <div class="page-wrapper">

        @include('partials.header')

        <main>
            <!--Start Banner One-->
            <section class="banner-one">
                <div class="banner-one__bg wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms"
                    style="background-image: url({{ asset($settings->home_banner_image ?: 'assets/img/slider/banner-one__mian-img.jpg') }});">
                </div>

                <div class="banner-one__bg-shape wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <div class="border-box"></div>
                </div>

                <div class="banner-one__shape1">
                    <img class="float-bob-y" src="{{ asset('assets/img/shape/banner-one__shape1.png') }}" alt="#">
                </div>
                <div class="banner-one__shape2 wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <img class="float-bob-y" src="{{ asset('assets/img/shape/banner-one__shape2.png') }}" alt="#">
                </div>
                <div class="container">
                    <div class="banner-one__content wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <div class="sub-title">
                            <h5>{{ $settings->hero_subtitle }}</h5>
                        </div>
                        <div class="big-title">
                            <h2>{!! $settings->hero_title !!}</h2>
                        </div>
                        <div class="text">
                            <p>{{ $settings->hero_text }}</p>
                        </div>
                        <div class="btn-box">
                            <a class="thm-btn" href="{{ route('track') }}">
                                <span class="txt">
                                    Track
                                    <i class="icon-next"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!--End Banner One-->

            @yield('content')
        </main>

        @include('partials.footer')

    </div>

    @stack('home_scripts')
@endsection
