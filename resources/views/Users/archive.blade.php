@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>Archive User</h1>
    <p>This user has bill associated with it. Do you really want to delete this user? "Yes" to delete, "No" to archive</p>

    <form class="" method="POST" action="/archiveuser/<?php echo $id; ?>" >
        @csrf        

        <button name="yes" class="mt-1 btn btn-primary" value="yes">Yes</button>
        <button name="no" class="mt-1 btn btn-primary" value="no">No</button>
    </form>

@endsection