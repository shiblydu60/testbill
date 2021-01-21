@extends('layouts.master')
@section('title', 'Dashboard')
@section('heading', 'Reports')
@section('content')
 
    {{-- <form class="" method="POST" action="/reports_with_params_admin" >
        @csrf
        <div class="position-relative form-group">
            <div>
                <label for="billDate" class="">From date</label>
                <input name="billDate_from" id="billDate" placeholder="From Date" type="text" data-toggle="datepicker" />
            
                <label for="billDate" class="">To date</label>
                <input name="billDate_to" id="billDate" placeholder="To Date" type="text" data-toggle="datepicker" />
            </div>
            <label for="project" class="">Projects</label>
            <select multiple="" name="project" id="project" class="form-control" style="max-width:50%;">
                <?php 
                    foreach($projects as $p) {
                        echo "<option value='$p->id'>$p->name</option>";
                    }
                ?>
            </select>
            <label for="user" class="">Users</label>
            <select multiple="" name="userid" id="userid" class="form-control" style="max-width:50%;">
                <?php 
                    foreach($users as $u) {
                        echo "<option value='$u->id'>$u->first_name $u->last_name</option>";
                    }
                ?>
            </select>
        
            <button class="mt-1 btn btn-primary" value="submit">Submit</button>
            
        </div>
    </form> --}}
    @if(count($bills)==0)
        <h2>There is no record.</h2>
    @endif
    <a href="/exporttofileadmin<?php echo $anc; ?>" class="float-right">Export to CSV</a>
    <table style="width: 100%;" class="table table-hover table-striped table-bordered" id="example3">
        <thead>
            <tr role="row">
                <th>Serial</th>
                <th>Bill Date</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Source</th>
                <th>Destination</th>
                <th>Purpose</th>
                <th>Comments</th>
                <th>File</th>
                <th>Status</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?<?php 
                $cnt=1;
            ?>
            @foreach ($bills as $bill)
                @if($bill->project->isdeleted==0)
                    <tr role="row" >
                        <td> {{ $cnt }}</td>
                        <td> {{ Carbon\Carbon::parse($bill->bill_date)->format('D M d, Y') }}</td>
                        <td> {{ $bill->user->first_name }} {{ $bill->user->last_name }}</td>
                        <td> {{ $bill->amount }}</td>
                        <td> {{ $bill->source }}</td>
                        <td> {{ $bill->destination }}</td>
                        <td> {{ $bill->project->name }}</td>
                        <td> {{ \Illuminate\Support\Str::limit($bill->comment, 200, $end='...') }} </td>
                        {{--  <td> <a href="/bills/{{ $bill->file_location }}/showfile">File</a></td>  --}}
                        <?php 
                            $pieces = explode("/", $bill->file_location);
                            $filename=$pieces[count($pieces)-1];
                        ?>
                        <td><a id="id_btn_file" href="{{ $bill->file_location }}" class="cl_btn_file mr-2 mb-2" data-toggle="modal" data-target=".bd-example-modal-lg">{{ $filename }}</a></td>
                        <td>
                            <?php
                                if($bill->status==1) {
                                    echo 'Approved';
                                }
                                else if($bill->status==2) {
                                    echo 'Rejected';
                                }
                                else {
                                    echo $bill->status;
                                }
                            ?>
                        </td>
                        <td> {{ Carbon\Carbon::parse($bill->created_at)->format('D M d, Y h:i:s') }}</td>
                        <td><a href="/bills/{{ $bill->id }}/edit">Edit</a></td>
                    </tr>
                    <?php $cnt=$cnt+1; ?>
                @endif
            @endforeach
            
        </tbody>       
    </table>

    {{-- <table style="width: 100%;" class="table table-hover table-striped table-bordered">
        <tbody>
            <tr>
                <td style="width: 8px" colspan="2"></td>
                <td>{{ $sum }}</td>
                <td colspan="7"></td>
            </tr>
        </tbody>
        
    </table> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var table=""; 
            setTimeout(function () {

                table=$('#example3').DataTable({
                    responsive: true,
                    // ordering: false,
                });

                table.row.add( [
                    "{{ $cnt }}",
                    "",
                    "Total",
                    {{ $sum }},
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",
                    "",                
             ] ).draw();             
                
            }, 2000);

            
        });
    </script>
@endsection
