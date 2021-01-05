@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>Edit User</h1>
    <form class="" method="POST" action="/users/<?php echo $user->id; ?>/update" >
        @csrf
        <div class="position-relative form-group">
            <label for="firstName" class="">First Name</label>
            <input name="firstName" id="firstName" placeholder="First Name" type="text" class="form-control" value="<?php echo $user->first_name; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="lastName" class="">Last Name</label>
            <input name="lastName" id="lasttName" placeholder="Last Name" type="text" class="form-control" value="<?php echo $user->last_name; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="userEmail" class="">Email</label>
            <input name="email" id="userEmail" placeholder="Email" type="email" class="form-control" value="<?php echo $user->email; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="userPassword" class="">Password</label>
            <input name="password" id="userPassword" placeholder="Password" type="password" class="form-control" value="<?php echo $user->password;  ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="role" class="">Roles</label>            
            <select name="role" id="role" class="form-control">
                <?php 
                    foreach($roles as $r) {
                        if($user->roles->first()->name==$r->name) {
                            echo "<option selected='true'>$r->name</option>";
                        } else {
                            echo "<option>$r->name</option>";
                        }
                        
                    }
                ?>
            </select>
        </div>

        <button class="mt-1 btn btn-primary">Submit</button>
    </form>

@endsection