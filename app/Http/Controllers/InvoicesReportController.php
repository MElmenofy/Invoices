<?php

namespace App\Http\Controllers;

use App\Invoices;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    //
    public function index(){

        return view('reports.invoices-report');
    }

    public function search_invoices(Request $request){
        $radio = $request->radio;
        // if radio = type_div -> نوع الفاتوره = value = 1
        if ($radio == 1){
            // اذا لم حدد تاريخ
            if ($request->type && $request->start_at=='' && $request->end_at==''){
                $invoices = Invoices::SELECT('*')->where('Status', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices-report', compact('type','invoices'));
            }
                // اذا حدد تاريخ
            else{
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $invoices = Invoices::WHEREBETWEEN('invoice_Date',[$start_at,$end_at])->where('Status', $request->type)->get();
                return view('reports.invoices-report', compact('type','invoices', 'start_at', 'end_at'));
            }
        }  //  /نوع الفاتوره
        // بحث برقم الفاتوره
        else{
            $invoices = Invoices::SELECT('*')->WHERE('invoice_number', $request->invoice_number)->get();
            return view('reports.invoices-report', compact('invoices'));
        }




    }
}
