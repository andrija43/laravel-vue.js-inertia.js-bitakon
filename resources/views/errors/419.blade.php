@extends('errors::minimal')
@section('title', __('419 Page Expired'))
@section('image')
<img src="{{ asset('assets/img/error/419.png') }}" height="300" alt="">
@endsection
@section('code', 'Error 419')
@section('message', __('Page Expired'))
