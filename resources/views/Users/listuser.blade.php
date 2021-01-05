@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>List User</h1>
    <table style="width: 100%;" class="table table-hover table-striped table-bordered">
        <thead>
            <tr role="row">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach ($users as $user)
                <tr role="row" >
                    <td> {{ $user->first_name }}</td>
                    <td> {{ $user->last_name }}</td>
                    <td> {{ $user->email }}</td>
                    <td><a href="/users/{{ $user->id }}/edit">Edit</a>&nbsp
                    <a href="/users/{{ $user->id }}/delete">Delete</a></td>
                </tr>
            @endforeach
        </tbody>       
    </table>            
    
    {{ $users->links("pagination::bootstrap-4") }}
@endsection
