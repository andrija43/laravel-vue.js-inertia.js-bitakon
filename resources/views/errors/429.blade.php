@extends('errors::minimal')
@section('title', __('429 Too Many Requests'))
@section('image')
<img src="{{ asset('assets/img/error/429.png') }}" height="500" alt="">
@endsection
