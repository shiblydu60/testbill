@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Reports')
@section('content')

    {{-- <form class="" method="POST" action="/reports_with_params_user" >
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
    </form> --}}
    <a href="/exporttofileuser<?php echo $anc; ?>" class="float-right">Export to CSV</a>
    @if(count($bills)==0)
        <h2>There is no record.</h2>
    @endif
    <table style="width: 100%;" class="table table-hover table-striped table-bordered" id="example">
        <thead>
            <tr role="row">
                <th>Bill Date</th>
                <th>Amount</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Project</th>
                <th>Comments</th>
                <th>File</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach ($bills as $bill)
                @if($bill->project->isdeleted==0)
                    <tr role="row" >
                        <td> {{ Carbon\Carbon::parse($bill->bill_date)->format('d-M-Y') }}</td>
                        <td> {{ $bill->amount }}</td>
                        <td> {{ $bill->source }}</td>
                        <td> {{ $bill->destination }}</td>
                        <td> {{ $bill->project->name }}</td>
                        <td> {{ \Illuminate\Support\Str::limit($bill->comment, 200, $end='...') }} </td>
                        {{--  <td> <a href="/bills/{{ $bill->file_location }}/showfile">File</a></td>  --}}
                        <td><a id="id_btn_file" href="{{ $bill->file_location }}" class="mr-2 mb-2" data-toggle="modal" data-target=".bd-example-modal-lg">File</a></td>
                        <td> {{ Carbon\Carbon::parse($bill->created_at)->format('d-M-Y') }}</td>
                    </tr>
                @endif
            @endforeach

            <tr>
                <td></td>
                <td>{{ $sum }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>       
    </table>            

@endsection