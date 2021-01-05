<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bill;
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
        return view('Bills.addbill');
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
        $obj->save();
        return view('Bills.storebill');
    }

    public function reports() {
        $bills = DB::table('transport_bills')->paginate(15);
        return view('Bills.reports', ['bills'=>$bills]);
    }

    public function edit($id) {
        $bill=Bill::findOrFail($id);
        //dd($bill->bill_date);
        return view('Bills.edit', ['bill'=>$bill]);
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
        $obj->save();
        return view('Bills.update');
    }

    public function reports_with_date(Request $request) {
        //dd($request->all());           
        $billDate_from=$request->input('billDate_from');
        $date = new DateTime($billDate_from);
        $d1=$date->format('Y-m-d H:i:s');
        $billDate_to=$request->input('billDate_to');
        $date = new DateTime($billDate_to);
        $d2=$date->format('Y-m-d H:i:s');
        $bills = DB::table('transport_bills')->where('bill_date', '>=', $d1)->where('bill_date', '<=', $d2)->paginate(15);
        //dd($bills);
        return view('Bills.reports_with_date', ['bills'=>$bills]);
    }
}