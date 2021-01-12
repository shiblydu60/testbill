@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Add Project')
@section('content')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form class="" method="POST" action="/storeproject" >
        @csrf
        
        <div class="position-relative form-group">
            <label for="projectName" class="">Project Name</label>
            <input name="projectName" id="projectName" placeholder="Project Name" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="description" class="">Description</label>            
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <button class="mt-1 btn btn-primary">Submit</button>
    </form>
@endsection
