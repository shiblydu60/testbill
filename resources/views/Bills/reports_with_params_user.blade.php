@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>Reports</h1>

    <form class="" method="POST" action="/reports_with_params_user" >
        @csrf
        <div class="position-relative form-group">
            <div>
                <label for="billDate" class="">From date</label>
                <input name="billDate_from" id="billDate" placeholder="From Date" type="text" data-toggle="datepicker" />
        
                <label for="billDate" class="">To date</label>
                <input name="billDate_to" id="billDate" placeholder="To Date" type="text" data-toggle="datepicker" />
            </div>
            <label for="project" class="">Projects</label>
            <select multiple="" name="project" id="project" class="form-control" style="max-width:50%;">
                <?php 
                    foreach($projects as $p) {
                        echo "<option value='$p->id'>$p->name</option>";
                    }
                ?>
            </select>
            <button class="mt-1 btn btn-primary">Submit</button>
        </div>
    </form>
    <table style="width: 100%;" class="table table-hover table-striped table-bordered">
        <thead>
            <tr role="row">
                <th>Bill Date</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach ($bills as $bill)
                <tr role="row" >
                    <td> {{ $bill->bill_date }}</td>
                    <td> {{ $bill->user->first_name }} {{ $bill->user->last_name }}</td>
                    <td> {{ $bill->amount }}</td>
                    <td> {{ $bill->source }}</td>
                    <td> {{ $bill->destination }}</td>
                    <td><a href="/bills/{{ $bill->id }}/edit">Edit</a></td>
                </tr>            
            @endforeach
        </tbody>       
    </table>            

@endsection