@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Approve Bills')
@section('content')

<table style="width: 100%;" class="table table-hover table-striped table-bordered" id="example">
    <thead>
        <tr role="row">
            <th>Bill Date</th>                
            <th>Name</th>
            <th>Amount</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Purpose</th>
            <th>Comments</th>
            <th>File</th>
            <th>Accountant approval</th>
            <th>Management approval</th>
            <th>Final approval date</th>            
            <th>Created</th>
            
        </tr>
    </thead>
    <tbody>
        
        @foreach ($bills as $bill)
            @if($bill->project->isdeleted==0 && $bill->user->isactive==1)
                <tr role="row" >
                    <td> {{ Carbon\Carbon::parse($bill->bill_date)->format('D M d, Y') }}</td>                        
                    <td> {{ $bill->user->first_name }} {{ $bill->user->last_name }}</td>
                    <td> {{ $bill->amount }}</td>
                    <td> {{ $bill->source }}</td>
                    <td> {{ $bill->destination }}</td>
                    <td> {{ $bill->project->name }}</td>
                    <td> {{ \Illuminate\Support\Str::limit($bill->comment, 200, $end='...') }} </td>
                    {{--  <td> <a href="/bills/{{ $bill->file_location }}/showfile">File</a></td>  --}}
                    <?php 
                        $pieces = explode("/", $bill->file_location);
                        $filename=$pieces[count($pieces)-1];
                    ?>
                    <td><a id="id_btn_file" href="{{ $bill->file_location }}" class="cl_btn_file mr-2 mb-2 " data-toggle="modal" data-target=".bd-example-modal-lg">{{ $filename }}</a></td>
                    <td>
                      <?php
                          if($bill->status==1) {
                              echo 'Approved';
                          }
                          else if($bill->status==2) {
                              echo 'Rejected';
                          }
                          else {
                              echo $bill->status;
                          }
                      ?>
                   </td>
                   <td> 
                    <?php
                        if($bill->superadmin_status==1) {
                            echo 'Approved';
                        }
                        else if($bill->superadmin_status==2) {
                            echo 'Rejected';
                        }
                        else {
                            echo $bill->superadmin_status;
                        }
                    ?>
                    
                    </td>
                   <td> 
                        @if($bill->superadmin_monitored_at != null) 
                            {{ Carbon\Carbon::parse($bill->superadmin_monitored_at)->format('D M d, Y h:i:s') }}
                        @endif
                    </td>
                    <td> {{ Carbon\Carbon::parse($bill->created_at)->format('D M d, Y h:i:s') }}</td>
                    
                </tr>
            @endif
        @endforeach
    </tbody>       
 </table>
 
 @if(count($bills)>0)
 <form class="" method="POST" action="/approveatonceadmin<?php echo $params; ?>" >    
    @csrf
    <div class="position-relative form-group">
        <label for="note" class="">Note</label>
        <textarea name="note" id="note" class="form-control" ></textarea>
    </div>
    <button class="mt-1 btn btn-primary">Approve all</button>
    </div>
</form>
@endif
@endsection