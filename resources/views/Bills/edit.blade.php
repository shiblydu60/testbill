@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <h1>Edit Bill</h1>
    <form class="" method="POST" action="/bills/<?php echo $bill->id; ?>/update" >
        @csrf
        
        <div class="position-relative form-group">
            <label for="billDate" class="">Bill Date</label>
            <input name="billDate" id="billDate" placeholder="Bill Date" type="text" class="form-control" data-toggle="datepicker" value="<?php echo $bill->bill_date; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="amount" class="">Amount</label>
            <input name="amount" id="amount" placeholder="Amount" type="text" class="form-control" value="<?php echo $bill->amount; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="source" class="">Source</label>
            <input name="source" id="source" placeholder="Source" type="text" class="form-control" value="<?php echo $bill->source; ?>" />
        </div>

        <div class="position-relative form-group">
            <label for="destination" class="">Destination</label>
            <input name="destination" id="destination" placeholder="Destination" type="text" class="form-control" value="<?php echo $bill->destination; ?>" />
        </div>
        <label for="project" class="">Projects</label>
        <select multiple="" name="project" id="project" class="form-control">
            <?php 
                foreach($projects as $p) {
                        if($p->id==$bill->project->id) {
                            echo "<option selected='true' value='$p->id'>$p->name</option>";
                        } else {
                            echo "<option value='$p->id'>$p->name</option>";
                        }
                    
                }
            ?>
        </select>
        <label for="user" class="">Users</label>
        <select multiple="" name="userid" id="userid" class="form-control">
            <?php 
                foreach($users as $u) {
                    if($u->id==$bill->user->id) {
                        echo "<option selected='true' value='$u->id'>$u->first_name $u->last_name</option>";
                    } else {
                        echo "<option value='$u->id'>$u->first_name $u->last_name</option>";
                    }                    
                }
            ?>
        </select>

        <button class="mt-1 btn btn-primary">Submit</button>
    </form>
@endsection
