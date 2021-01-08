@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>Add User</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form class="" method="POST" action="/storeuser" >
        @csrf
        <div class="position-relative form-group">
            <label for="firstName" class="">First Name</label>
            <input name="firstName" id="firstName" placeholder="First Name" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="lastName" class="">Last Name</label>
            <input name="lastName" id="lasttName" placeholder="Last Name" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="designation" class="">Designation</label>
            <input name="designation" id="designation" placeholder="Designation" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="userEmail" class="">Email</label>
            <input name="email" id="userEmail" placeholder="Email" type="email" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="userPassword" class="">Password</label>
            <input name="password" id="userPassword" placeholder="Password" type="password" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="role" class="">Roles</label>            
            <select name="role" id="role" class="form-control">
                <?php 
                    foreach($roles as $r) {
                        if($r->name != 'superadmin') {
                            echo "<option>$r->name</option>";
                        }
                    }
                ?>
            </select>
        </div>

        <button class="mt-1 btn btn-primary">Submit</button>
    </form>

@endsection
    