<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bill;
use App\Models\Project;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Session;
use Illuminate\Support\Facades\Storage;

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
        if($request->input('project')==0) {
            $obj->project_id=1;    
        } else {
            $obj->project_id=$request->input('project');
        }
        if(!empty($request->file('file'))) {            
            $path = $request->file('file')->storeAs(
                'public/uploads', $request->file('file')->getClientOriginalName()
            );
            //dd($path);
            $obj->file_location=$path;
        }
        $obj->comment=$request->input('comment');
        $obj->save();
        $request->session()->flash('message', 'Bill saved successfully.');
        return redirect()->intended('/listbilluser');
        //return view('Bills.storebill');
    }

    public function edit($id) {
        $projects=Project::all();
        $users=User::all();
        $bill=Bill::with(['project', 'user'])->findOrFail($id);
        //dd($projects);
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
        if (!empty($request->file('file'))) {
            $path = $request->file('file')->storeAs(
                'public/uploads',
                $request->file('file')->getClientOriginalName()
            );
            $obj->file_location=$path;
        }
        $obj->project_id=$request->input('project');
        $obj->user_id=$request->input('userid');
        $obj->comment=$request->input('comment');
        //dd($request->all());
        $obj->save();
        $request->session()->flash('message', 'Bill updated successfully.');
        return redirect()->intended('/listbilladmin');
        //return view('Bills.update');
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
        if($request->input('project')==0) {
            $obj->project_id=1;    
        } else {
            $obj->project_id=$request->input('project');
        }
        $obj->comment=$request->input('comment');
        //dd($request->all());
        if (!empty($request->file('file'))) {
            $path = $request->file('file')->storeAs(
                'public/uploads',
                $request->file('file')->getClientOriginalName()
            );
            $obj->file_location=$path;
        }        
        //dd($path);
        
        $obj->save();
        $request->session()->flash('message', 'Bill saved successfully.');
        return redirect()->intended('/listbilladmin');
        //return view('Bills.storebilladmin');
    }
    
    public function listbilladmin(Request $request) {
        $bills=Bill::with(['user', 'project'])->orderBy('bill_date')->get();
        /*
        $bills = Bill::select('*')
                ->join('users', 'transport_bills.user_id', '=', 'users.id')
                ->join('projects', 'transport_bills.project_id', '=', 'projects.id')
                ->orderBy('transport_bills.bill_date', 'DESC')->get();
                //->paginate(10);    
        
        //dd($bills);
        */
        return view('Bills.listbilladmin', ['bills' => $bills]);
    }

    public function listbilluser() {
        $aid=Auth::id();
        $bills = Bill::with(['user', 'project'])->where('user_id', '=', $aid)->get();
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
        
        $projects=Project::all();
        $users=User::all();
        //dd($request->all());
                
        if(!empty($request->input('billDate_from'))) {
            $billDate_from=$request->input('billDate_from');
            $date = new DateTime($billDate_from);
            $d1=$date->format('Y-m-d H:i:s');            
        } else {
            $d1="";
        }
        
        if(!empty($request->input('billDate_to'))) {
            $billDate_to=$request->input('billDate_to');
            $date = new DateTime($billDate_to);
            $d2=$date->format('Y-m-d H:i:s');
        } else {
            $d2="";
        }
        
        $userid=[];
        $userid=$request->input('userid');
        $projectid=[];
        $projectid=$request->input('project');

        //dd($request->all());
       
        if(count($projectid)==1 && $projectid[0]==0) {
            $projectid=[];
        }
        if(count($userid)==1 && $userid[0]==0) {
            $userid=[];
        }
        //dd(count($projectid));
        //DB::enableQueryLog();
        if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && count($projectid)>0 && count($userid)>0 ) {            
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('user_id', $userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->whereIn('project_id', $projectid)->get();
        }
        else if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && count($projectid)==0 && count($userid)>0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('user_id', $userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }
        else if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && count($projectid)>0 && count($userid)==0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->whereIn('project_id', $projectid)->get();
        }
        else if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && count($projectid)==0 && count($userid)==0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }

        else if((empty($request->input('billDate_from')) || empty($request->input('billDate_to'))) && count($projectid)>0 && count($userid)>0) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('user_id', $userid)->whereIn('project_id', $projectid)->get();            
        }
        else if((empty($request->input('billDate_from')) || empty($request->input('billDate_to'))) && count($projectid)==0 && count($userid)>0) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('user_id', $userid)->get();
        }
        else if((empty($request->input('billDate_from')) || empty($request->input('billDate_to'))) && count($projectid)>0 && count($userid)==0) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('project_id', $projectid)->get();
        }
        else {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->get();
        }
        //dd(DB::getQueryLog());
        //dd($bills);
        $sum=0;
        foreach($bills as $b) {
            if($b->project->isdeleted==0) {
                $sum=$sum + $b->amount;
            }            
        }
        $uid="";
        if (count($userid)>0) {
            $uid=$userid[0];
            for ($i=1;$i<count($userid);$i++) {
                $uid=$uid . ',' . $userid[$i];
            }
        }
        $pid=""; 
        if (count($projectid)>0) {
            $pid=$projectid[0];
            for ($i=1;$i<count($projectid);$i++) {
                $pid=$pid . ',' . $projectid[$i];
            }
        }
        $anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&userid=" . $uid . "&projectid=" . $pid;
        return view('Bills.reports_with_params_admin', ['bills'=>$bills, 'projects'=>$projects, 'users'=>$users, 'anc'=>$anc, 'sum'=>$sum]);
    }

    public function reportsuser() {
        $projects=Project::all();
        $aid=Auth::id();
        $bills = DB::table('transport_bills')->where('user_id', '=', $aid)->paginate(15);
        return view('Bills.reportsuser', ['bills' => $bills, 'projects' => $projects]);
    }

    public function reports_with_params_user(Request $request) {
                
        $projects=Project::all();
        $aid=Auth::id();
        if(!empty($request->input('billDate_from'))) {
            $billDate_from=$request->input('billDate_from');
            $date = new DateTime($billDate_from);
            $d1=$date->format('Y-m-d H:i:s');            
        } else {
            $d1="";
        }
        
        if(!empty($request->input('billDate_to'))) {
            $billDate_to=$request->input('billDate_to');
            $date = new DateTime($billDate_to);
            $d2=$date->format('Y-m-d H:i:s');            
        } else {
            $d2="";
        }
        $projectid=[];
        $projectid=$request->input('project');
        if(count($projectid)==1 && $projectid[0]==0) {
            $projectid=[];
        }
        
        //dd($request->all());
        //DB::enableQueryLog();
        if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && count($projectid)>0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('user_id', '=', $aid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->whereIn('project_id', $projectid)->get();
        }
        else if(!empty($request->input('billDate_from')) && !empty($request->input('billDate_to')) && count($projectid)==0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('user_id', '=', $aid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }
        else if ((empty($request->input('billDate_from')) || empty($request->input('billDate_to')) )  && count($projectid)>0) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('user_id', '=', $aid)->whereIn('project_id', $projectid)->get();
        }
        else {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('user_id', '=', $aid)->get();
        }
        //dd(DB::getQueryLog());
        //dd($bills);
        $sum=0;
        foreach($bills as $b) {
            if ($b->project->isdeleted==0) {
                $sum=$sum + $b->amount;
            }
        }
        $pid="";
        if(count($projectid)>0) {
            $pid=$projectid[0];
            for($i=1;$i<count($projectid);$i++) {
                $pid=$pid . ',' . $projectid[$i];
            }
        }

        $anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&userid=$aid" . "&projectid=" . $pid;
        return view('Bills.reports_with_params_user', ['bills'=>$bills, 'projects'=>$projects, 'anc'=>$anc, 'sum'=>$sum]);
    }

    public function exporttofileadmin(Request $request) {
        //$anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&userid=" . $userid . "&projectid=" . $projectid;        
        
        if(!empty($request->query('billDate_from'))) {
            $billDate_from=$request->query('billDate_from');
            $date = new DateTime($billDate_from);
            $d1=$date->format('Y-m-d H:i:s');
        } else {
            $d1="";
        }
        if(!empty($request->query('billDate_to'))) {
            $billDate_to=$request->query('billDate_to');
            $date = new DateTime($billDate_to);
            $d2=$date->format('Y-m-d H:i:s');
        } else {
            $d2="";
        }
        
        if(!empty($request->query('userid'))) {
            $userid = explode(',', $request->query('userid'));
        } else {
            $userid=[];
        }
        if(!empty($request->query('project'))) {
            $projectid = explode(',', $request->query('project'));
        } else {
            $projectid=[];
        }
        

        if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && count($projectid)>0 && count($userid)>0 ) {            
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('user_id', $userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->whereIn('project_id', $projectid)->get();
        }
        else if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && count($projectid)==0 && count($userid)>0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('user_id', $userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }
        else if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && count($projectid)>0 && count($userid)==0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->whereIn('project_id', $projectid)->get();
        }
        else if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && count($projectid)==0 && count($userid)==0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }

        else if((empty($request->query('billDate_from')) || empty($request->query('billDate_to'))) && count($projectid)>0 && count($userid)>0) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('user_id', $userid)->whereIn('project_id', $projectid)->get();            
        }
        else if((empty($request->query('billDate_from')) || empty($request->query('billDate_to'))) && count($projectid)==0 && count($userid)>0) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('user_id', $userid)->get();
        }
        else if((empty($request->query('billDate_from')) || empty($request->query('billDate_to'))) && count($projectid)>0 && count($userid)==0) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->whereIn('project_id', $projectid)->get();
        }
        else {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->get();
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

        $columns = array('bill_date', 'name', 'amount', 'source', 'destination', 'project', 'comment', 'created');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                if ($task->project->isdeleted==0) {
                    
                    $billDate=$task->bill_date;
                    $date = new DateTime($billDate);
                    $d1=$date->format('D M d, Y');

                    $row['bill_date']  = $d1;
                    $row['name']  = $task->user->first_name . ' ' . $task->user->last_name;
                    $row['amount']    = $task->amount;
                    $row['source']    = $task->source;
                    $row['destination']  = $task->destination;
                    $row['project']  = $task->project->name;
                    $row['comment'] = $task->comment;

                    $created=$task->created_at;
                    $date = new DateTime($created);
                    $d1=$date->format('D M d, Y');

                    $row['created'] = $d1;

                    fputcsv($file, array($row['bill_date'], $row['name'], $row['amount'], $row['source'], $row['destination'], $row['project'], $row['comment'], $row['created'] ));
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exporttofileuser(Request $request) {
        //$anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&userid=" . $userid . "&projectid=" . $projectid;        

        if(!empty($request->query('billDate_from'))) {
            $billDate_from=$request->query('billDate_from');
            $date = new DateTime($billDate_from);
            $d1=$date->format('Y-m-d H:i:s');
        } else {
            $d1="";
        }
        if(!empty($request->query('billDate_to'))) {
            $billDate_to=$request->query('billDate_to');
            $date = new DateTime($billDate_to);
            $d2=$date->format('Y-m-d H:i:s');
        } else {
            $d2="";
        }

        $aid=$request->query('userid');
        
        if(!empty($request->query('project'))) {
            $projectid = explode(',', $request->query('project'));
        } else {
            $projectid=[];
        }

        if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && count($projectid)>0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('user_id', '=', $aid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->whereIn('project_id', $projectid)->get();
        }
        else if(!empty($request->query('billDate_from')) && !empty($request->query('billDate_to')) && count($projectid)==0 ) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('user_id', '=', $aid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        }
        else if ((empty($request->query('billDate_from')) || empty($request->query('billDate_to')) )  && count($projectid)>0) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('user_id', '=', $aid)->whereIn('project_id', $projectid)->get();
        }
        else {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('user_id', '=', $aid)->get();
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

        $columns = array('bill_date', 'amount', 'source', 'destination', 'project', 'comment', 'created');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($tasks as $task) {
                if ($task->project->isdeleted==0) {
                    $billDate_from=$task->bill_date;
                    $date = new DateTime($billDate_from);
                    $d1=$date->format('D M d, Y');
            
                    $row['bill_date']  = $d1;
                    $row['amount']    = $task->amount;
                    $row['source']    = $task->source;
                    $row['destination']  = $task->destination;
                    $row['project']  = $task->project->name;
                    $row['comment'] = $task->comment;
                
                    $created_at=$task->created_at;
                    $date = new DateTime($created_at);
                    $d1=$date->format('D M d, Y');
                    $row['created_at'] = $d1;
                

                    fputcsv($file, array($row['bill_date'], $row['amount'], $row['source'], $row['destination'], $row['project'], $row['comment'], $row['created_at']));
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);        
    }

    public function showfile($id1, $id2, $id3) {
        $file=$id1 . '/' . $id2 . '/' . $id3;
        //dd($id1 . '/' . $id2 . '/' . $id3);
        return view('Bills.showfile',['file'=>$file]);
    }

    public function monitorbill() {
        $bills=Bill::with(['user', 'project'])->orderBy('bill_date')->get();
        //dd($bills);
        return view('Bills.monitorbill', ['bills'=>$bills]);
    }

    public function monitorbilladmin() {
        $bills=Bill::with(['user', 'project'])->where('status','1')->orderBy('bill_date')->get();
        //dd($bills);
        return view('Bills.monitorbilladmin', ['bills'=>$bills]);
    }

    public function approveformadmin($id) {
        //dd($id);
        $bill=Bill::with(['project', 'user'])->findOrFail($id);
        return view('Bills.approveformadmin', ['bill'=>$bill]);
    }

    public function approvebilladmin(Request $request, $id) {
        $bill=Bill::with(['project', 'user'])->findOrFail($id);

        //dd($request->all());
        //dd(Auth::user()->first_name . ' ' . Auth::user()->last_name);
        $bill->monitored_by=Auth::id();
        $bill->superadmin_status=1;
        $bill->superadmin_note=$request->input('note');
        $bill->superadmin_monitored_at=Carbon::now();
        $bill->save();
        $request->session()->flash('message', 'Bill approved successfully.');
        return redirect()->intended('/monitorbilladmin');
    }


    public function approveform($id) {
        //dd($id);
        $bill=Bill::with(['project', 'user'])->findOrFail($id);
        return view('Bills.approveform', ['bill'=>$bill]);
    }

    public function approvebill(Request $request, $id) {
        $bill=Bill::with(['project', 'user'])->findOrFail($id);

        //dd($request->all());
        //dd(Auth::user()->first_name . ' ' . Auth::user()->last_name);
        $bill->monitored_by=Auth::id();
        $bill->status=1;
        $bill->note=$request->input('note');
        $bill->monitored_at=Carbon::now();
        $bill->save();
        $request->session()->flash('message', 'Bill approved successfully.');
        return redirect()->intended('/monitorbill');
    }

    public function rejectformadmin($id) {
        $bill=Bill::with(['project', 'user'])->findOrFail($id);
        return view('Bills.rejectformadmin', ['bill'=>$bill]);
    }

    public function rejectbilladmin(Request $request, $id) {
        $bill=Bill::with(['project', 'user'])->findOrFail($id);

        //dd($request->all());
        //dd(Auth::user()->first_name . ' ' . Auth::user()->last_name);
        $bill->monitored_by=Auth::id();
        $bill->superadmin_status=2;
        $bill->superadmin_note=$request->input('note');
        $bill->superadmin_monitored_at=Carbon::now();
        $bill->save();
        $request->session()->flash('message', 'Bill rejected successfully.');
        return redirect()->intended('/monitorbilladmin');
    }

    public function rejectform($id) {
        $bill=Bill::with(['project', 'user'])->findOrFail($id);
        return view('Bills.rejectform', ['bill'=>$bill]);
    }

    public function rejectbill(Request $request, $id) {
        $bill=Bill::with(['project', 'user'])->findOrFail($id);

        //dd($request->all());
        //dd(Auth::user()->first_name . ' ' . Auth::user()->last_name);
        $bill->monitored_by=Auth::id();
        $bill->status=2;
        $bill->note=$request->input('note');
        $bill->monitored_at=Carbon::now();
        $bill->save();
        $request->session()->flash('message', 'Bill rejected successfully.');
        return redirect()->intended('/monitorbill');
    }

    public function searchtoapproveform() {
        $projects=Project::all();
        $users=User::all();
        $bills = DB::table('transport_bills')->paginate(15);
        return view('Bills.searchtoapproveform', ['bills'=>$bills, 'projects'=>$projects, 'users'=>$users]);        
    }

    
    public function searchtoapproveformadmin() {
        $projects=Project::all();
        $users=User::all();
        $bills = DB::table('transport_bills')->paginate(15);
        return view('Bills.searchtoapproveformadmin', ['bills'=>$bills, 'projects'=>$projects, 'users'=>$users]);        
    }

    public function listtoapprove(Request $request) {
        if(!empty($request->input('billDate_from'))) {
            $billDate_from=$request->input('billDate_from');
            $date = new DateTime($billDate_from);
            $d1=$date->format('Y-m-d H:i:s');            
        } else {
            $d1="";
        }
        
        if(!empty($request->input('billDate_to'))) {
            $billDate_to=$request->input('billDate_to');
            $date = new DateTime($billDate_to);
            $d2=$date->format('Y-m-d H:i:s');            
        } else {
            $d2="";
        }
        $userid=$request->input('userid');
        //dd($request->all());
        $bills = Bill::with(['user', 'project'])->whereNull('status')->where('user_id','=',$userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        //dd($bills);
        $params="?billDate_from=$d1&billDate_to=$d2&userid=$userid";
        return view('Bills.listtoapprove', ['bills'=>$bills,'params'=>$params]);
    }

    public function listtoapproveadmin(Request $request) {
        if(!empty($request->input('billDate_from'))) {
            $billDate_from=$request->input('billDate_from');
            $date = new DateTime($billDate_from);
            $d1=$date->format('Y-m-d H:i:s');            
        } else {
            $d1="";
        }
        
        if(!empty($request->input('billDate_to'))) {
            $billDate_to=$request->input('billDate_to');
            $date = new DateTime($billDate_to);
            $d2=$date->format('Y-m-d H:i:s');            
        } else {
            $d2="";
        }
        $userid=$request->input('userid');
        //dd($request->all());
        $bills = Bill::with(['user', 'project'])->where('status','=','1')->whereNull('superadmin_status')->where('user_id','=',$userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        //dd($bills);
        $params="?billDate_from=$d1&billDate_to=$d2&userid=$userid";
        return view('Bills.listtoapproveadmin', ['bills'=>$bills,'params'=>$params]);
    }

    public function approveatonce(Request $request) {
        $d1=$request->input('billDate_from');
        $d2=$request->input('billDate_to');
        $userid=$request->input('userid');
        $aid=Auth::id();
        //dd(Auth::user()->first_name);
        //$auser=Auth::user()->first_name . Auth::user()->last_name;
        $auser=Auth::id();
        $note=$request->input('note');
        Bill::whereNull('status')->where('user_id','=',$userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->update(['status'=>1, 'note'=>$note, 'monitored_by'=>$auser, 'monitored_at'=>Carbon::now()]);
        $request->session()->flash('message', 'Bill approved successfully.');
        return redirect()->intended('/monitorbill');
        //dd($userid);
    }

    public function approveatonceadmin(Request $request) {
        $d1=$request->input('billDate_from');
        $d2=$request->input('billDate_to');
        $userid=$request->input('userid');
        $aid=Auth::id();
        //dd(Auth::user()->first_name);
        //$auser=Auth::user()->first_name . Auth::user()->last_name;
        $auser=Auth::id();
        $note=$request->input('note');
        Bill::where('status','=','1')->where('user_id','=',$userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->update(['superadmin_status'=>1, 'superadmin_note'=>$note, 'monitored_by'=>$auser, 'superadmin_monitored_at'=>Carbon::now()]);
        $request->session()->flash('message', 'Bill approved successfully.');
        return redirect()->intended('/monitorbilladmin');
        //dd($userid);
    }

    public function monthlyreportform() {
        $users=User::all();
        return view('Bills.monthlyreportform',['users'=>$users]);
    }

    public function monthlyreport(Request $request) {
        $month=$request->input('month');
        $userid=$request->input('userid');
        //dd($userid);
        $curr_year=now()->year;
        $d1="$curr_year-$month-01";
        $d2=Carbon::parse($d1)->endOfMonth()->toDateString();
        $bills = Bill::with(['user', 'project'])->where('superadmin_status','=','1')->where('user_id','=',$userid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        //dd($bills);
        //dd($request->all());
        $sum=0;
        foreach($bills as $b) {
            if($b->project->isdeleted==0) {
                $sum=$sum + $b->amount;
            }            
        }
        $anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&userid=" . $userid;
        return view('Bills.monthlyreport', ['bills' => $bills, 'sum'=>$sum, 'anc'=>$anc]);
    }

    public function exporttofilemonth(Request $request) {
        //$anc="?billDate_from=" . $d1 . "&billDate_to=" . $d2 . "&userid=" . $userid . "&projectid=" . $projectid;
        //dd($request->all());
        if (!empty($request->query('billDate_from'))) {
            $billDate_from=$request->query('billDate_from');
            $date = new DateTime($billDate_from);
            $d1=$date->format('Y-m-d H:i:s');
        } else {
            $d1="";
        }
        if (!empty($request->query('billDate_to'))) {
            $billDate_to=$request->query('billDate_to');
            $date = new DateTime($billDate_to);
            $d2=$date->format('Y-m-d H:i:s');
        } else {
            $d2="";
        }

        $aid=$request->query('userid');

        if (!empty($request->query('billDate_from')) && !empty($request->query('billDate_to'))) {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status', '=', '1')->where('user_id', '=', $aid)->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->get();
        } else {
            $bills = Bill::with(['user', 'project'])->where('superadmin_status', '=', '1')->where('user_id', '=', $aid)->get();
        }
        //dd($bills);
        $fileName = 'report.csv';
        $tasks = $bills;

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('bill_date', 'amount', 'source', 'destination', 'project', 'comment', 'created');

        $callback = function () use ($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            foreach ($tasks as $task) {
                if ($task->project->isdeleted==0) {
                    $billDate_from=$task->bill_date;
                    $date = new DateTime($billDate_from);
                    $d1=$date->format('D M d, Y');
            
                    $row['bill_date']  = $d1;
                    $row['amount']    = $task->amount;
                    $row['source']    = $task->source;
                    $row['destination']  = $task->destination;
                    $row['project']  = $task->project->name;
                    $row['comment'] = $task->comment;
                
                    $created_at=$task->created_at;
                    $date = new DateTime($created_at);
                    $d1=$date->format('D M d, Y');
                    $row['created_at'] = $d1;
                

                    fputcsv($file, array($row['bill_date'], $row['amount'], $row['source'], $row['destination'], $row['project'], $row['comment'], $row['created_at']));
                }
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

}
