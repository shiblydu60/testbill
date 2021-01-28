@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Approve Bill')
@section('content')

    <div>Bill Date: {{ Carbon\Carbon::parse($bill->bill_date)->format('D M d, Y') }}</div>
    <div>Amount: {{ $bill->amount }}</div>
    <div>Source: {{ $bill->source }}</div>
    <div>Destination: {{ $bill->destination }}</div>
    <div>Purpose: {{ $bill->project->name }}</div>
    <div>Comment: {{ $bill->comment }}</div>
    
    <form class="" method="POST" action="/bills/{{ $bill->id }}/approvebilladmin" >
        @csrf
        
        <div class="position-relative form-group">
            <label for="note" class="">Note</label>
            <textarea name="note" id="note" class="form-control" ></textarea>
        </div>
        <button class="mt-1 btn btn-primary">Approve</button>
    </form>

@endsection