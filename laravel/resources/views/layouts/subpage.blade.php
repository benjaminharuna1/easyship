@extends('layouts.base')

@section('content')
    @include('partials.page-header', ['title' => $title ?? 'Page'])
    @yield('page_content')
@endsection

@section('footer')
    @include('partials.footer', ['footerVariant' => '--two'])
@endsection

@section('scripts')
    @stack('page_scripts')
@endsection
