@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>List Bill</h1>

    <table style="width: 100%;" class="table table-hover table-striped table-bordered">
        <thead>
            <tr role="row">
                <th>Bill Date</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Source</th>
                <th>Destination</th>               
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
                </tr>            
            @endforeach
        </tbody>       
    </table>            

    {{ $bills->links("pagination::bootstrap-4") }}

@endsection