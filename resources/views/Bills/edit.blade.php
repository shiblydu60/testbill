@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>Edit Bill</h1>
    <form class="" method="POST" action="/bills/<?php echo $bill->id; ?>/update" >
        @csrf
        
        <div class="position-relative form-group">
            <label for="billDate" class="">Bill Date</label>
            <input name="billDate" id="billDate" placeholder="Bill Date" type="text" class="form-control" data-toggle="datepicker" value="<?php echo $bill->bill_date; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="amount" class="">Amount</label>
            <input name="amount" id="amount" placeholder="Amount" type="text" class="form-control" value="<?php echo $bill->amount; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="source" class="">Source</label>
            <input name="source" id="source" placeholder="Source" type="text" class="form-control" value="<?php echo $bill->source; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="destination" class="">Destination</label>
            <input name="destination" id="destination" placeholder="Destination" type="text" class="form-control" value="<?php echo $bill->destination; ?>" />
        </div>

        <button class="mt-1 btn btn-primary">Submit</button>
    </form>
@endsection
