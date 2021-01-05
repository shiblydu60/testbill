@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    @if(Session::has('message'))
        <p class="alert">{{ Session::get('message') }}</p>
    @endif
@endsection