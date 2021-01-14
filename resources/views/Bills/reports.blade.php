@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Reports')
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
    <form class="" method="POST" action="/reports_with_params_admin" >
        @csrf
        <div class="position-relative form-group">
            <div>
                <label for="billDate" class="">From date</label>
                <input name="billDate_from" id="billDate" placeholder="From Date" class="form-control w-50" type="text" data-toggle="datepicker" />
            
                <label for="billDate" class="">To date</label>
                <input name="billDate_to" id="billDate" placeholder="To Date" class="form-control w-50" type="text" data-toggle="datepicker" />
            </div>
            <label for="project" class="">Projects</label>
            <select multiple="" name="project[]" id="project" class="form-control" style="max-width:50%;">
                <option value='0' selected>(empty)</option>
                <?php 
                    foreach($projects as $p) {
                        if($p->isdeleted==0) {
                            echo "<option value='$p->id'>$p->name</option>";
                        }
                    }
                ?>
            </select>
            <label for="user" class="">Users</label>
            <select multiple="" name="userid[]" id="userid" class="form-control" style="max-width:50%;">
                <option value='0' selected='selected'>(empty)</option>
                <?php 
                    foreach($users as $u) {
                        echo "<option value='$u->id'>$u->first_name $u->last_name</option>";
                    }
                ?>
            </select>
            <button class="mt-1 btn btn-primary">Submit</button>
        </div>
    </form>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="datepicker"]').datepicker({endDate: new Date()});
        });
    </script>
@endsection
