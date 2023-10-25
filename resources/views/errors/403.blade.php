@extends('errors::minimal')
@section('title', __('403 Forbidden'))
@section('image')
<img src="{{ asset('assets/img/error/403.png') }}" height="500" alt="">
@endsection
