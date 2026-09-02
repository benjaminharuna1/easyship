@extends('emails.layout')

@section('email_title', ($settings->sitename ?? 'EasyShip') . ' Notification')

@section('content')
    {!! $body ?? '' !!}
@endsection
