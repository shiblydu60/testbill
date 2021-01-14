@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Add Bill')
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
    <form class="" method="POST" action="/storebilladmin" >
        @csrf
        
        <div class="position-relative form-group">
            <label for="userid" class="">User name</label>
            <select name="userid" id="userid" class="form-control">
                <?php 
                    foreach($users as $u) {
                        echo "<option value='$u->id'>$u->first_name $u->last_name</option>";
                    }
                ?>
            </select>
        </div>

        <div class="position-relative form-group">
            <label for="billDate" class="">Bill Date</label>
            <input name="billDate" id="billDate" placeholder="Bill Date" type="text" class="form-control" data-toggle="datepicker" />
        </div>

        <div class="position-relative form-group">
            <label for="amount" class="">Amount</label>
            <input name="amount" id="amount" placeholder="Amount" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="source" class="">Source</label>
            <input name="source" id="source" placeholder="Source" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="destination" class="">Destination</label>
            <input name="destination" id="destination" placeholder="Destination" type="text" class="form-control" />
        </div>

        <div class="position-relative form-group">
            <label for="project" class="">Project</label>
            <select name="project" id="project" class="form-control">
                <option value='0'>Select Project</option>
                <?php 
                    foreach($projects as $p) {
                        if($p->isdeleted==0) {
                            echo "<option value='$p->id'>$p->name</option>";
                        }
                    }
                ?>
            </select>
        </div>

        <div class="position-relative form-group">
            <label for="comment" class="">Comment</label>
            <textarea name="comment" id="comment" class="form-control"></textarea>
        </div>

        <button class="mt-1 btn btn-primary">Submit</button>
    </form>
    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="datepicker"]').datepicker({
                endDate: new Date(),
                autoHide: true
            });
        });
    </script>
@endsection
