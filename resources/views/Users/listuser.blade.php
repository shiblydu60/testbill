@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'List User')
@section('content')

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
                @if($user->isactive==1)
                    <tr role="row" >
                        <td> {{ $user->first_name }}</td>
                        <td> {{ $user->last_name }}</td>
                        <td> {{ $user->email }}</td>
                        <td><a href="/users/{{ $user->id }}/edit">Edit</a>&nbsp
                        @if ($user->email != 'superadmin@admin.com')
                            <a href="/users/{{ $user->id }}/delete">Delete</a></td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </tbody>       
    </table>            
    
    {{ $users->links("pagination::bootstrap-4") }}
@endsection
