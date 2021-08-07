<?php

namespace App\Http\Controllers;
use App\Notifications\InvoiceAdded;
use Illuminate\Support\Facades\Notification;
use App\invoice_attachments;
use App\Invoices;
use App\Invoices_details;
use App\sections;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\In;
use MongoDB\Driver\Session;
use App\Notifications\AddInvoice;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoices = Invoices::all();
        return view('invoices.invoices', compact('invoices'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sections = sections::all();
        return view('invoices.add-invoices', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        invoices::create([
                'invoice_number' => $request->invoice_number,
                'invoice_Date' => $request->invoice_Date,
                'Due_date' => $request->Due_date,
                'product' => $request->product,
                'section_id' => $request->section,
                'Amount_collection' => $request->Amount_collection,
                'Amount_Commission' => $request->Amount_Commission,
                'Discount' => $request->Discount,
                'Value_VAT' => $request->Value_VAT,
                'Rate_VAT' => $request->Rate_VAT,
                'Total' => $request->Total,
                'Status' => 'غير مدفوعة',
                'Value_Status' => 2,
                'note' => $request->note,
            ]);
        //  invoices_details
            $invoice_id = Invoices::latest()->first()->id;
            Invoices_details::create([
                'id_invoice'=> $invoice_id,
                'invoice_number'=> $request->invoice_number,
                'product'=> $request->product,
                'section'=> $request->section,
                'Status' => 'غير مدفوعة',
                'Value_Status' => 2,
                'note' => $request->note,
                'user'=> (Auth::user()->name),
            ]);

            // invoices attachments
        if ($request->hasFile('file')) {

            $invoice_id = Invoices::latest()->first()->id;
            // هضيف فالدين
            $image = $request->file('file');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();
            // move pic
            $imageName = $request->file->getClientOriginalName();
            $request->file->move(public_path('Attachments/' . $invoice_number), $imageName);

        }
        // notification to email
//            $user = User::first();
//            Notification::send($user, new AddInvoice($invoice_id));


        // notification to db
        // noti to all users ->  $user = User::get();
        // noti to user created pill:  $user = User::find(Auth::user()->id);
        // noti to Admin:
        $user = User::get();
        $invoice_id = Invoices::latest()->first();
        Notification::send($user, new InvoiceAdded($invoice_id));


        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        return view('invoices.status-update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit-invoices', compact('invoices', 'sections'));




        //
//        $invoices = Invoices::where('id', $id)->first();
//        $details = Invoices_details::where('id_invoice', $id)->get();
//        $attachments = invoice_attachments::where('invoice_id', $id)->get();
//        return view('invoices.datails-invoices', compact('invoices', 'details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $invoices = invoices::findOrFail($request->invoice_id);
//        $invoices->update($request->all());
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }

    public function open_file($invoice_number, $file_name){

        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/'. $file_name );
        return response()->file($files);
    }

    public function download_file($invoice_number, $file_name){

        $download = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/'. $file_name );
        return response()->download($download);
    }

    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = Invoices::where('id', $id)->first();
        $attachment = invoice_attachments::where('invoice_id', $id)->first();
        $id_page = $request->id_page;
        if (!$id_page ==2){
        if (!empty($attachment->invoice_number)){
            Storage::disk('public_uploads')->deleteDirectory($attachment->invoice_number);
        }
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/invoices');
        }else{
            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }
    }

    public function Status_Update($id, Request $request){
        $invoices = Invoices::findOrFail($id);
        if ($request->Status === 'مدفوعة'){
            $invoices->update([
                'Value_Status'=>1,
                'Status'=>$request->Status,
                'Payment_Date'=>$request->Payment_Date,
            ]);

            Invoices_details::create([
                'id_invoice'=>$request->invoice_id,
                'invoice_number'=> $request->invoice_number,
                'product'=> $request->product,
                'section'=> $request->section,
                'Status' =>$request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date'=>$request->Payment_Date,
                'user'=> (Auth::user()->name),
            ]);
        }else{
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            Invoices_details::create([
                'id_invoice'=>$request->invoice_id,
                'invoice_number'=> $request->invoice_number,
                'product'=> $request->product,
                'section'=> $request->section,
                'Status' =>$request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date'=>$request->Payment_Date,
                'user'=> (Auth::user()->name),
            ]);
        }
        session()->flash('status_update');
        return redirect('/invoices');
    }

    public function invoices_paid(){
        $invoices = Invoices::where('Value_Status',1)->get();
        return view('invoices.invoices-paid', compact('invoices'));
    }

    public function invoices_unpaid(){
        $invoices = Invoices::where('Value_Status',2)->get();
        return view('invoices.invoices-unpaid', compact('invoices'));
    }

    public function invoices_partial(){
        $invoices = Invoices::where('Value_Status',3)->get();
        return view('invoices.invoices-partial', compact('invoices'));
    }

    public function print_invoice($id){
        $invoices = Invoices::where('id', $id)->first();
        return view('invoices.print-invoice', compact('invoices'));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
        //
    }

    public function markAsReadAll(Request $request){
        $userUnreadNotifications = auth()->user()->unreadNotifications;

        if ($userUnreadNotifications){
            $userUnreadNotifications->markAsRead();
            return redirect()->back();
        }
    }
}

