@extends('layouts.subpage')

@section('title', ($settings->sitename ?? 'EasyShip') . ' | ' . $page->page_title)

@section('page_content')

    <!--Start Legal Content Section-->
    <section class="legal-content-section" style="padding: 120px 0;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="legal-content-box">
                        {!! $page->page_content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Legal Content Section-->

@endsection
