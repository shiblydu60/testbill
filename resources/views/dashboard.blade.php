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
            <th>Project</th>
            <th>Comments</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
    
        @foreach ($daysBills as $bill)
            @if($bill->project->isdeleted==0)
                <tr role="row" >
                    <td> {{ Carbon\Carbon::parse($bill->bill_date)->format('d-M-Y') }}</td>
                    <td> {{ $bill->amount }}</td>
                    <td> {{ $bill->source }}</td>
                    <td> {{ $bill->destination }}</td>
                    <td> {{ $bill->project->name }}</td>
                    <td> {{ \Illuminate\Support\Str::limit($bill->comment, 200, $end='...') }} </td>
                    <td> {{ Carbon\Carbon::parse($bill->created_at)->format('d-M-Y') }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>       
</table>
@endif
@endsection