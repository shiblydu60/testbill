@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Approve Bill')
@section('content')

    <form class="" method="POST" action="/bills/{{ $bill->id }}/approvebill" >
        @csrf
        
        <div class="position-relative form-group">
            <label for="note" class="">Note</label>
            <textarea name="note" id="note" class="form-control" ></textarea>
        </div>
        <button class="mt-1 btn btn-primary">Approve</button>
    </form>

@endsection