@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>List Project</h1>
    <table style="width: 100%;" class="table table-hover table-striped table-bordered">
        <thead>
            <tr role="row">
                <th>Name</th>
                <th>Description</th>                               
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach ($projects as $p)
                <tr role="row" >
                    <td> {{ $p->name }}</td>
                    <td> {{ $p->description }}</td>                    
                    <td><a href="/projects/{{ $p->id }}/edit">Edit</a>&nbsp                    
                        <a href="/projects/{{ $p->id }}/delete">Delete</a>
                    </td>                    
                </tr>
            @endforeach
        </tbody>       
    </table>            

    {{ $projects->links("pagination::bootstrap-4") }}
@endsection