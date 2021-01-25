<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Bill;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        //dd(bcrypt('123'));
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }
        return view('index');
    }

    public function loginget() {
        
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }
        return view('index');
    }

    public function login(Request $request) {
    
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard() {
        //dd(Auth::user()->roles->first()->name);
        $auser=Auth::user();
        $aid=Auth::id();
        //dd($auser->roles->first()->name);
        $bills=Bill::with(['user', 'project'])->whereIn('status',[null,'2'])->get();
        //dd($bills);
        if ($auser->roles->first()->name=='superadmin' || $auser->roles->first()->name=='accounts') {
            $weekBill=Bill::with(['project'])->where('status','=','1')->whereBetween('bill_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $sumWeek=0;
            foreach ($weekBill as $w) {
                if ($w->project->isdeleted==0) {
                    $sumWeek=$sumWeek+$w->amount;
                }
            }
            //dd($sumWeek);
            $monthBill=Bill::with(['project'])->where('status','=','1')->whereMonth('bill_date', date('m'))->get();
            $sumMonth=0;
            foreach ($monthBill as $m) {
                if ($m->project->isdeleted==0) {
                    $sumMonth=$sumMonth+$m->amount;
                }
            }
            //$yearBill=Bill::whereYear('bill_date', date('Y'))->sum('amount');
            $yearBill=Bill::with(['project'])->where('status','=','1')->whereYear('bill_date', date('Y'))->get();
            $sumYear=0;
            foreach ($yearBill as $y) {
                if ($y->project->isdeleted==0) {
                    $sumYear=$sumYear+$y->amount;
                }
            }
            $daysBills_admin=Bill::with(['user', 'project'])->where('status','=','1')->orderBy('bill_date', 'DESC')->limit(3)->get();
            //dd($daysBills);
            return view('dashboard', ['weekBill'=>$sumWeek,'monthBill'=>$sumMonth, 'yearBill'=>$sumYear, 'daysBills_admin'=>$daysBills_admin, 'bills'=>$bills]);
        }
        if ($auser->roles->first()->name=='user') {
            $weekBill=Bill::with(['project'])->where('user_id', '=', $aid)->where('status','=','1')->whereBetween('bill_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $sumWeek=0;
            foreach ($weekBill as $w) {
                if ($w->project->isdeleted==0) {
                    $sumWeek=$sumWeek+$w->amount;
                }
            }
            //dd($sumWeek);
            $monthBill=Bill::with(['project'])->where('user_id', '=', $aid)->where('status','=','1')->whereMonth('bill_date', date('m'))->get();
            $sumMonth=0;
            foreach ($monthBill as $m) {
                if ($m->project->isdeleted==0) {
                    $sumMonth=$sumMonth+$m->amount;
                }
            }
            //$yearBill=Bill::whereYear('bill_date', date('Y'))->sum('amount');
            $yearBill=Bill::with(['project'])->where('user_id', '=', $aid)->where('status','=','1')->whereYear('bill_date', date('Y'))->get();
            $sumYear=0;
            foreach ($yearBill as $y) {
                if ($y->project->isdeleted==0) {
                    $sumYear=$sumYear+$y->amount;
                }
            }
            $daysBills=Bill::with(['user', 'project'])->where('user_id', '=', $aid)->where('status','=','1')->orderBy('bill_date', 'DESC')->limit(3)->get();
            //dd($daysBills);
            return view('dashboard', ['weekBill'=>$sumWeek,'monthBill'=>$sumMonth, 'yearBill'=>$sumYear, 'daysBills'=>$daysBills, 'bills'=>$bills]);
        }
        
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function adduser() {
        $roles=Role::all();
        return view('Users.adduser', ['roles' => $roles]);
    }

    public function storeuser(Request $request) {
        /*
        echo '<pre>';
        var_dump($request->all());
        echo '</pre>';
        */
        $validated = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'designation' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);
        $obj=new User();
        $obj->first_name=$request->input('firstName');
        $obj->last_name=$request->input('lastName');
        $obj->designation=$request->input('designation');
        $obj->email=$request->input('email');
        $obj->password=bcrypt($request->input('password'));
        $obj->isactive=1;
        $obj->save();
        $email=$request->input('email');
        $role=$request->input('role');
        $user = User::where('email', $email)->first();
        $user->assignRole($role);
        $request->session()->flash('message', 'User saved successfully.');
        return redirect()->intended('/listuser');
        //return view('Users.storeuser');
    }

    public function listuser(Request $request) {
        $users = DB::table('users')->paginate(15);
        return view('Users.listuser', ['users'=>$users]);
    }

    public function edit($id) {
        $user=User::with('roles')->findOrFail($id);
        $password = Hash::make($user->password);
        //dd($password);
        //dd($user->roles->first()->name);
        $roles=Role::all();
        return view('Users.edit', ['user'=>$user, 'roles'=>$roles]);
    }

    public function update(Request $request, $id) {
        $obj=User::with('roles')->findOrFail($id);
        $old_role=$obj->roles->first()->name;
        //dd($old_role);
        $obj->first_name=$request->input('firstName');
        $obj->last_name=$request->input('lastName');
        $obj->designation=$request->input('designation');
        $obj->email=$request->input('email');
        $obj->password=bcrypt($request->input('password'));        
        $obj->save();        
        $email=$request->input('email');
        $role=$request->input('role');
        //dd($role);
        $user = User::where('email', $email)->first();
        $user->removeRole($old_role);
        $user->assignRole($role);
        $request->session()->flash('message', 'User updated successfully.');
        return redirect()->intended('/listuser');
        //return view('Users.update');
    }

    public function delete($id) {
        //dd('delete user');
        $obj=User::with(['roles', 'bills'])->findOrFail($id);
        //dd($obj->bills->all());
        if(count($obj->bills->all())>0) {
            return view('Users.archive', ['id' => $id]);
        } else {
            $old_role=$obj->roles->first()->name;
            $email=$obj->email;
            $user = User::where('email', $email)->first();
            $user->removeRole($old_role);
            $obj->delete();
            return view('Users.delete');
        }
        //dd(count($obj->bills->all()) );
        /*
        $old_role=$obj->roles->first()->name;
        $email=$obj->email;
        $user = User::where('email', $email)->first();
        $user->removeRole($old_role);
        $obj->delete();
        return view('Users.delete');
        */
    }

    public function archiveuser(Request $request, $id) {
        $obj=User::with(['roles', 'bills'])->findOrFail($id);
        //dd($obj);
        if($request->has('yes')) {
            $yes=$request->input('yes');
            $old_role=$obj->roles->first()->name;
            $email=$obj->email;
            $user = User::where('email', $email)->first();
            $user->removeRole($old_role);
            $obj->delete();
            return view('Users.delete');
        } else {
            $no=$request->input('no');
            $obj->isactive=0;
            $obj->save();
            return view('Users.archived');
        }
        
    }
}
