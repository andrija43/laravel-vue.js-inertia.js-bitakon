@extends('errors::minimal')

@section('title', __('Server Error'))
@section('image')
<img src="{{ asset('assets/img/error/500.png') }}" height="500" alt="">
@endsection
