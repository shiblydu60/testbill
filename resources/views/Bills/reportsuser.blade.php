@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Reports')
@section('content')
   
    <form class="" method="POST" action="/reports_with_params_user" >
        @csrf
        <div class="position-relative form-group">
            <div>
                <label for="billDate" class="">From date</label>
                <input name="billDate_from" id="billDate" placeholder="From Date" type="text" class="form-control w-50" data-toggle="datepicker" />
        
                <label for="billDate" class="">To date</label>
                <input name="billDate_to" id="billDate" placeholder="To Date" type="text" class="form-control w-50" data-toggle="datepicker" />
            </div>
            <label for="project" class="">Projects</label>
            <select multiple="" name="project[]" id="project" class="form-control" style="max-width:50%;">
                <option value='0' selected='selected'>...Select Project</option>
                <?php
                    foreach($projects as $p) {
                        if($p->isdeleted==0) {
                            echo "<option value='$p->id'>$p->name</option>";
                        }
                    }
                ?>
            </select>
            <button class="mt-1 btn btn-primary">Submit</button>
        </div>
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
