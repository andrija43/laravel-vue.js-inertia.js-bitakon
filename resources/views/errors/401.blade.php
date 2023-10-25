@extends('errors::minimal')
@section('title', __('401 Unauthorized'))
@section('image')
<img src="{{ asset('assets/img/error/401.png') }}" height="500" alt="">
@endsection
