@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Monthly Report')
@section('content')

    <form class="" method="POST" action="/monthlyreport" >
        @csrf
        <div class="position-relative form-group">
            <div class="form-row">
                
                <div class="col-md-4">
                    <label for="month" class="">Select Month</label>
                    <select name="month" id="month" class="form-control">
                        <option value='1'>January</option>
                        <option value='2'>Februay</option>
                        <option value='3'>March</option>
                        <option value='4'>April</option>
                        <option value='5'>May</option>
                        <option value='6'>June</option>
                        <option value='7'>July</option>
                        <option value='8'>August</option>
                        <option value='9'>September</option>
                        <option value='10'>October</option>
                        <option value='11'>November</option>
                        <option value='12'>December</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="userid" class="">Select User</label>
                    <select name="userid" id="userid" class="form-control">
                        <?php 
                            foreach($users as $u) {
                                echo "<option value='$u->id'>$u->first_name $u->last_name</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <button class="mt-1 btn btn-primary">Submit</button>
    </form>

@endsection