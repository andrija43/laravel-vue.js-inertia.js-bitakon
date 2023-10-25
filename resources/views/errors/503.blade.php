@extends('errors::minimal')
@section('title', __('503 Service Unavailable'))
@section('image')
<img src="{{ asset('assets/img/error/503.png') }}" height="500" alt="">
@endsection
