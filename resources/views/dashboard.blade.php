@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
@section('heading', 'Welcome to Transport Bill Management')
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Total bills in this week</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>                            
                                {{ $weekBill }} TK
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Total bills in this month</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>                            
                                {{ $monthBill }} TK
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="widget-chart widget-chart2 text-left mb-3 card-btm-border card-shadow-primary border-primary card">
            <div class="widget-chat-wrapper-outer">
                <div class="widget-chart-content">
                    <div class="widget-title opacity-5 text-uppercase">Total bills in this year</div>
                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                        <div class="widget-chart-flex align-items-center">
                            <div>                            
                                {{ $yearBill }} TK
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  @if(Auth::user()->hasRole('user'))
<table style="width: 100%;" class="table table-hover table-striped table-bordered" id="example">
    <thead>
        <tr role="row">
            <th>Bill Date</th>
            <th>Amount</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Purpose</th>
            <th>Comments</th>
            <th>Status</th>
            <th>Note for status</th>
            <th>Approved at</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
    
        @foreach ($daysBills as $bill)
            @if($bill->project->isdeleted==0)
                <tr role="row" >
                    <td> {{ Carbon\Carbon::parse($bill->bill_date)->format('D M d, Y') }}</td>
                    <td> {{ $bill->amount }}</td>
                    <td> {{ $bill->source }}</td>
                    <td> {{ $bill->destination }}</td>
                    <td> {{ $bill->project->name }}</td>
                    <td> {{ \Illuminate\Support\Str::limit($bill->comment, 200, $end='...') }} </td>
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
                    <td> {{ $bill->note }}</td>
                   <td> {{ Carbon\Carbon::parse($bill->monitored_at)->format('D M d, Y h:i:s') }}</td>
                    <td> {{ Carbon\Carbon::parse($bill->created_at)->format('D M d, Y h:i:s') }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>       
</table>
@endif

{{--
@if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('accounts'))
<table style="width: 100%;" class="table table-hover table-striped table-bordered" id="example">
    <thead>
        <tr role="row">
            <th>Bill Date</th>
            <th>Amount</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Purpose</th>
            <th>Comments</th>
            <th>Status</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
    
        @foreach ($daysBills_admin as $bill)
            @if($bill->project->isdeleted==0)
                <tr role="row" >
                    <td> {{ Carbon\Carbon::parse($bill->bill_date)->format('D M d, Y') }}</td>
                    <td> {{ $bill->amount }}</td>
                    <td> {{ $bill->source }}</td>
                    <td> {{ $bill->destination }}</td>
                    <td> {{ $bill->project->name }}</td>
                    <td> {{ \Illuminate\Support\Str::limit($bill->comment, 200, $end='...') }} </td>
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
                    <td> {{ Carbon\Carbon::parse($bill->created_at)->format('D M d, Y h:i:s') }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>       
</table>
@endif  --}}

@if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('accounts'))
<h3>Approve or Reject bill</h3>
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
            <th>Status</th>
            <th>Note for status</th>
            <th>Approved at</th>
            <th>Created</th>            
            <th>Action</th>
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
                   <td> {{ $bill->note }}</td>
                   <td> {{ Carbon\Carbon::parse($bill->monitored_at)->format('D M d, Y h:i:s') }}</td>
                    <td> {{ Carbon\Carbon::parse($bill->created_at)->format('D M d, Y h:i:s') }}</td>
                    <td> <a href="/bills/{{ $bill->id }}/approveform">Approve</a>&nbsp<a href="/bills/{{ $bill->id }}/rejectform">Reject</a></td>
                </tr>
            @endif
        @endforeach
    </tbody>       
 </table>
@endif

<script>
    $( document ).ready(function() {
    setTimeout(function () {
        $('#example2').DataTable({
            responsive: true
        });
    }, 2000);
});
</script>

@endsection