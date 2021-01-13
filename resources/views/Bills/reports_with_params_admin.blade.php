@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Reports')
@section('content')
 
    {{-- <form class="" method="POST" action="/reports_with_params_admin" >
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
            <label for="user" class="">Users</label>
            <select multiple="" name="userid" id="userid" class="form-control" style="max-width:50%;">
                <?php 
                    foreach($users as $u) {
                        echo "<option value='$u->id'>$u->first_name $u->last_name</option>";
                    }
                ?>
            </select>
        
            <button class="mt-1 btn btn-primary" value="submit">Submit</button>
            
        </div>
    </form> --}}
    <a href="/exporttofileadmin<?php echo $anc; ?>" class="float-right">Export to CSV</a>
    <table style="width: 100%;" class="table table-hover table-striped table-bordered">
        <thead>
            <tr role="row">
                <th>Bill Date</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Project</th>
                <th>Comments</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach ($bills as $bill)
                <tr role="row" >
                    <td> {{ Carbon\Carbon::parse($bill->bill_date)->format('Y-M-d H i s') }}</td>
                    <td> {{ $bill->user->first_name }} {{ $bill->user->last_name }}</td>
                    <td> {{ $bill->amount }}</td>
                    <td> {{ $bill->source }}</td>
                    <td> {{ $bill->destination }}</td>
                    @if($bill->project->isdeleted==0)
                        <td> {{ $bill->project->name }}</td>
                    @else
                        <td> {{ $bill->project->name }} (deleted)</td>
                    @endif
                    <td> {{ \Illuminate\Support\Str::limit($bill->comment, 200, $end='...') }} </td>
                    <td><a href="/bills/{{ $bill->id }}/edit">Edit</a></td>
                </tr>            
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td>{{ $sum }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>       
    </table>            
    
@endsection
