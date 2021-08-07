<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\sections;
use Illuminate\Http\Request;

class CustomersReportController extends Controller
{
    //
    public function index(){
        $sections = sections::all();
        return view('reports.customers-report', compact('sections'));
    }

    public function search_customers(Request $request){
        // في حالة عدم تحديد تاريخ
        if ($request->Section && $request->product && $request->start_at == '' && $request->end_at == ''){
            $invoices = Invoices::SELECT('*')->WHERE('section_id', $request->Section)->WHERE('product', $request->product)->get();
            $sections = sections::all();
            return view('reports.customers-report', compact('invoices','sections'));
        } // في حالة البحث بالتاريخ
        else{
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = Invoices::WHEREBETWEEN('invoice_Date',[$start_at, $end_at])->WHERE('section_id', $request->Section)->WHERE('product', $request->product)->get();
            $sections = sections::all();
            return view('reports.customers-report', compact('invoices','sections'));

        }
    }

}
