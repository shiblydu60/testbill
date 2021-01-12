@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'List Project')
@section('content')

    <table style="width: 100%;" class="table table-hover table-striped table-bordered">
        <thead>
            <tr role="row">
                <th>Name</th>
                <th>Description</th>
                <th>Created</th>
                <th>Total</th>                 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach ($projects as $p)
                @if($p->isdeleted==0)
                    <tr role="row" >
                        <td> {{ $p->name }}</td>
                        <td> {{ $p->description }}</td>
                        <td> {{ $p->created_at }}</td>
                        <td> {{ $p->bills->sum('amount') }}</td>
                        <td><a href="/projects/{{ $p->id }}/edit">Edit</a>&nbsp
                            @if($p->id!=1)
                                <a href="/projects/{{ $p->id }}/delete">Delete</a>
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>       
    </table>            

    {{ $projects->links("pagination::bootstrap-4") }}
@endsection