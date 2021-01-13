@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'List Bill')
@section('content')

    <table style="width: 100%;" class="table table-hover table-striped table-bordered" id="example">
        <thead>
            <tr role="row">
                <th>Bill Date</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Project</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach ($bills as $bill)
                @if($bill->project->isdeleted==0)
                    <tr role="row" >
                        <td> {{ Carbon\Carbon::parse($bill->bill_date)->format('Y-M-d H i s') }}</td>
                        <td> {{ $bill->user->first_name }} {{ $bill->user->last_name }}</td>
                        <td> {{ $bill->amount }}</td>
                        <td> {{ $bill->source }}</td>
                        <td> {{ $bill->destination }}</td>
                        <td> {{ $bill->project->name }}</td>                        
                        <td> {{ \Illuminate\Support\Str::limit($bill->comment, 200, $end='...') }} </td>
                    </tr>
                @endif
            @endforeach
        </tbody>       
    </table>            

    {{--  {{ $bills->links("pagination::bootstrap-4") }}  --}}

@endsection