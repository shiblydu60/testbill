@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>Edit User</h1>
    <form class="" method="POST" action="/projects/<?php echo $project->id; ?>/update" >
        @csrf
        <div class="position-relative form-group">
            <label for="projectName" class="">Name</label>
            <input name="projectName" id="projectName" placeholder="Project Name" type="text" class="form-control" value="<?php echo $project->name; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="description" class="">Description</label>            
            <textarea name="description" id="description" class="form-control"><?php echo $project->description; ?></textarea>
        </div>

        <button class="mt-1 btn btn-primary">Submit</button>
    </form>

@endsection