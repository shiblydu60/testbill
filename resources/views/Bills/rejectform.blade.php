@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Reject Bill')
@section('content')

    <form class="" method="POST" action="/bills/{{ $bill->id }}/rejectbill" >
        @csrf
        
        <div class="position-relative form-group">
            <label for="note" class="">Note</label>
            <textarea name="note" id="note" class="form-control" ></textarea>
        </div>
        <button class="mt-1 btn btn-primary">Reject</button>
    </form>

@endsection