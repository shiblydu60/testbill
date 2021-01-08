<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bill;
use App\Models\Project;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{

    /**
     * Functon CreateBill 
     * description"
     * @param 
     * @return type
     * 
    */
    public function addbill() {
        $projects=Project::all();
        //dd($projects);
        return view('Bills.addbill', ['projects' => $projects]);
    }

    public function storebill(Request $request) {
        $validated = $request->validate([
            'billDate' => 'required',
            'amount' => 'required',
            'source' => 'required',
            'destination' => 'required',
        ]);
        $obj=new Bill();
        $obj->user_id=Auth::id();
        $billdate=$request->input('billDate');
        $date = new DateTime($billdate);
        //dd($date->format('Y-m-d H:i:s'));
        $obj->bill_date=$date->format('Y-m-d H:i:s');
        $obj->amount=$request->input('amount');
        $obj->source=$request->input('source');
        $obj->destination=$request->input('destination');
        $obj->project_id=$request->input('project');
        $obj->comment=$request->input('comment');
        $obj->save();
        return view('Bills.storebill');
    }

    public function edit($id) {
        $projects=Project::all();
        $users=User::all();
        $bill=Bill::with(['project', 'user'])->findOrFail($id);
        //dd($bill->project->name);
        //dd($bill->user->first_name);
        return view('Bills.edit', ['bill'=>$bill, 'projects'=>$projects, 'users'=>$users]);
    }

    public function update(Request $request, $id) {
        $obj=Bill::findOrFail($id);        
        $billdate=$request->input('billDate');
        $date = new DateTime($billdate);
        //dd($date->format('Y-m-d H:i:s'));
        $obj->bill_date=$date->format('Y-m-d H:i:s');
        $obj->amount=$request->input('amount');
        $obj->source=$request->input('source');
        $obj->destination=$request->input('destination');
        $obj->project_id=$request->input('project');
        $obj->user_id=$request->input('userid');
        $obj->save();
        return view('Bills.update');
    }

    public function addbilladmin() {
        $projects=Project::all();
        $users=User::all();
        return view('Bills.addbilladmin', ['projects' => $projects, 'users' => $users]);
    }

    public function storebilladmin(Request $request) {
        $validated = $request->validate([
            'userid' => 'required',
            'billDate' => 'required',
            'amount' => 'required',
            'source' => 'required',
            'destination' => 'required',
        ]);
        $obj=new Bill();
        $obj->user_id=$request->input('userid');
        $billdate=$request->input('billDate');
        $date = new DateTime($billdate);
        //dd($date->format('Y-m-d H:i:s'));
        $obj->bill_date=$date->format('Y-m-d H:i:s');
        $obj->amount=$request->input('amount');
        $obj->source=$request->input('source');
        $obj->destination=$request->input('destination');
        $obj->project_id=$request->input('project');
        $obj->comment=$request->input('comment');
        $obj->save();
        return view('Bills.storebilladmin');
    }
    
    public function listbill() {
        $bills=Bill::with(['user', 'project'])->paginate(15);
        return view('Bills.listbill', ['bills' => $bills]);
    }

    public function listbilluser() {
        $aid=Auth::id();
        $bills = Bill::where('user_id', '=', $aid)->paginate(15);        
        return view('Bills.listbilluser', ['bills' => $bills]);
    }

    public function reports() {
        $projects=Project::all();
        $users=User::all();
        $bills = DB::table('transport_bills')->paginate(15);
        return view('Bills.reports', ['bills'=>$bills, 'projects'=>$projects, 'users'=>$users]);
    }

    public function reports_with_params_admin(Request $request) {
        //dd($request->method());
        $validated = $request->validate([
            'billDate_from' => 'required',
            'billDate_to' => 'required',            
        ]);
        $projects=Project::all();
        $users=User::all();
        //dd($request->all());           
        $billDate_from=$request->input('billDate_from');
        $date = new DateTime($billDate_from);
        $d1=$date->format('Y-m-d H:i:s');
        $billDate_to=$request->input('billDate_to');
        $date = new DateTime($billDate_to);
        $d2=$date->format('Y-m-d H:i:s');
        $userid=$request->input('userid');
        $projectid=$request->input('project');
        //dd($request->all());
        if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && !empty($request->input('project')) && !empty($request->input('userid')) ) {
            $bills = Bill::with(['user', 'project'])->where('user_id', '=', $userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->where('project_id', '=', $projectid)->get();
        }
        else if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && empty($request->input('project')) && !empty($request->input('userid')) ) {
            $bills = Bill::with(['user', 'project'])->where('user_id', '=', $userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }
        else if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && !empty($request->input('project')) && empty($request->input('userid')) ) {
            $bills = Bill::with(['user', 'project'])->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->where('project_id', '=', $projectid)->get();
        }
        else if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && empty($request->input('project')) && empty($request->input('userid')) ) {
            $bills = Bill::with(['user', 'project'])->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }
        else {
            $bills = Bill::with(['user', 'project'])->get();
        }
        //dd($bills);
        $anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&userid=" . $userid . "&projectid=" . $projectid;
        return view('Bills.reports_with_params_admin', ['bills'=>$bills, 'projects'=>$projects, 'users'=>$users, 'anc'=>$anc]);
    }

    public function reportsuser() {
        $projects=Project::all();
        $aid=Auth::id();
        $bills = DB::table('transport_bills')->where('user_id', '=', $aid)->paginate(15);
        return view('Bills.reportsuser', ['bills' => $bills, 'projects' => $projects]);
    }

    public function reports_with_params_user(Request $request) {
        $validated = $request->validate([
            'billDate_from' => 'required',
            'billDate_to' => 'required',            
        ]);        
        $projects=Project::all();
        $aid=Auth::id();
        $projectid=$request->input('project');
        $billDate_from=$request->input('billDate_from');
        $date = new DateTime($billDate_from);
        $d1=$date->format('Y-m-d H:i:s');
        $billDate_to=$request->input('billDate_to');
        $date = new DateTime($billDate_to);
        $d2=$date->format('Y-m-d H:i:s');
        //dd($request->all());
        if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && !empty($request->input('project')) ) {
            $bills = Bill::with(['user', 'project'])->where('user_id', '=', $aid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->where('project_id', '=', $project)->get();
        } else if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && empty($request->input('project'))) {
            $bills = Bill::with(['user', 'project'])->where('user_id', '=', $aid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        } else {
            $bills = Bill::with(['user', 'project'])->where('user_id', '=', $aid)->get();
        }        
        //dd($bills);
        $anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&projectid=" . $projectid;
        return view('Bills.reports_with_params_user', ['bills'=>$bills, 'projects'=>$projects, 'anc'=>$anc]);
    }

    public function exporttofileadmin(Request $request) {
        //$anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&userid=" . $userid . "&projectid=" . $projectid;        

        $billDate_from=$request->query('billDate_from');
        $date = new DateTime($billDate_from);
        $d1=$date->format('Y-m-d H:i:s');
        $billDate_to=$request->query('billDate_to');
        $date = new DateTime($billDate_to);
        $d2=$date->format('Y-m-d H:i:s');
        $userid=$request->query('userid');
        $projectid=$request->query('project');

        if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && !empty($request->query('project')) && !empty($request->query('userid')) ) {
            $bills = Bill::with(['user', 'project'])->where('user_id', '=', $userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->where('project_id', '=', $projectid)->get();
        }
        else if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && empty($request->query('project')) && !empty($request->query('userid')) ) {
            $bills = Bill::with(['user', 'project'])->where('user_id', '=', $userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }
        else if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && !empty($request->query('project')) && empty($request->query('userid')) ) {
            $bills = Bill::with(['user', 'project'])->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->where('project_id', '=', $projectid)->get();
        }
        else if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && empty($request->query('project')) && empty($request->query('userid')) ) {
            $bills = Bill::with(['user', 'project'])->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }
        else {
            $bills = Bill::with(['user', 'project'])->get();
        }
        
        $fileName = 'report.csv';
        $tasks = $bills;

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('bill_date', 'name', 'amount', 'source', 'destination');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $row['bill_date']  = $task->bill_date;
                $row['name']  = $task->user->first_name . ' ' . $task->user->last_name;
                $row['amount']    = $task->amount;
                $row['source']    = $task->source;
                $row['destination']  = $task->destination;

                fputcsv($file, array($row['bill_date'], $row['name'], $row['amount'], $row['source'], $row['destination']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);        
    }

    public function exporttofileuser(Request $request) {
        //$anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&userid=" . $userid . "&projectid=" . $projectid;        

        $billDate_from=$request->query('billDate_from');
        $date = new DateTime($billDate_from);
        $d1=$date->format('Y-m-d H:i:s');
        $billDate_to=$request->query('billDate_to');
        $date = new DateTime($billDate_to);
        $d2=$date->format('Y-m-d H:i:s');
        $projectid=$request->query('project');

        if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && !empty($request->query('project')) ) {
            $bills = Bill::with(['user', 'project'])->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->where('project_id', '=', $projectid)->get();
        }
        else if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && empty($request->query('project')) ) {
            $bills = Bill::with(['user', 'project'])->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }        
        else {
            $bills = Bill::with(['user', 'project'])->get();
        }
        
        $fileName = 'report.csv';
        $tasks = $bills;

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('bill_date', 'amount', 'source', 'destination');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $row['bill_date']  = $task->bill_date;
                $row['amount']    = $task->amount;
                $row['source']    = $task->source;
                $row['destination']  = $task->destination;

                fputcsv($file, array($row['bill_date'], $row['amount'], $row['source'], $row['destination']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);        
    }
}
