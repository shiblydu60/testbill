@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>Add Bill</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form class="" method="POST" action="/storebill" >
        @csrf
        
        <div class="position-relative form-group">
            <label for="billDate" class="">Bill Date</label>
            <input name="billDate" id="billDate" placeholder="Bill Date" type="text" class="form-control" data-toggle="datepicker" />
        </div>

        <div class="position-relative form-group">
            <label for="amount" class="">Amount</label>
            <input name="amount" id="amount" placeholder="Amount" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="source" class="">Source</label>
            <input name="source" id="source" placeholder="Source" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="destination" class="">Destination</label>
            <input name="destination" id="destination" placeholder="Destination" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="project" class="">Project</label>
            <select name="project" id="project" class="form-control">
                <?php 
                    foreach($projects as $p) {
                        echo "<option value='$p->id'>$p->name</option>";
                    }
                ?>
            </select>
        </div>

        <div class="position-relative form-group">
            <label for="comment" class="">Comment</label>
            <textarea name="comment" id="comment" class="form-control"></textarea>
        </div>

        <button class="mt-1 btn btn-primary">Submit</button>
    </form>
@endsection
