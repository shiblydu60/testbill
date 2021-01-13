@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'List Bill')
@section('content')

    Sort by: 
    <select name="sortby" onchange="location = this.value;">
        <option value="/listbilladmin" >Default</option>
        <option value="/listbilladmin?sort=bill_date&orderby=ASC" @if($url=="/listbilladmin?sort=bill_date&orderby=ASC") selected @endif>Bill Date ASC</option>
        <option value="/listbilladmin?sort=bill_date&orderby=DESC" @if($url=="/listbilladmin?sort=bill_date&orderby=DESC") selected @endif>Bill Date DESC</option>
        <option value="/listbilladmin?sort=amount&orderby=ASC"  @if($url=="/listbilladmin?sort=amount&orderby=ASC") selected @endif>Amount ASC</option>
        <option value="/listbilladmin?sort=amount&orderby=DESC" @if($url=="/listbilladmin?sort=amount&orderby=DESC") selected @endif>Amount DESC</option>
        <option value="/listbilladmin?sort=first_name&orderby=ASC"  @if($url=="/listbilladmin?sort=first_name&orderby=ASC") selected @endif>Name ASC</option>
        <option value="/listbilladmin?sort=first_name&orderby=DESC" @if($url=="/listbilladmin?sort=first_name&orderby=DESC") selected @endif>Name DESC</option>
        
    </select>
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
            </tr>
        </thead>
        <tbody>
        
            @foreach ($bills as $bill)
                <tr role="row" >
                    <td> {{ Carbon\Carbon::parse($bill->bill_date)->format('Y-M-d H i s') }}</td>
                    <td> {{ $bill->first_name }} {{ $bill->last_name }}</td>
                    <td> {{ $bill->amount }}</td>
                    <td> {{ $bill->source }}</td>
                    <td> {{ $bill->destination }}</td>
                    @if($bill->isdeleted==1)
                        <td> {{ $bill->name }} (deleted)</td>
                    @else
                        <td> {{ $bill->name }}</td>
                    @endif
                    <td> {{ \Illuminate\Support\Str::limit($bill->comment, 200, $end='...') }} </td>
                </tr>            
            @endforeach
        </tbody>       
    </table>            

    {{ $bills->links("pagination::bootstrap-4") }}

@endsection