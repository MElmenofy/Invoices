<?php

namespace App\Http\Controllers;

use App\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

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
        $request->validate([
            'file_name'=> 'mimes:pdf,jpe,png,jpeg'
        ],[
                'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            ]);
        $file_extension = $request->file_name-> getclientoriginalextension();
        $file_name = time().'.'.$file_extension;
        $path = 'Attachments/'. $request->invoice_number; // in folder
        $request ->file_name->move($path, $file_name);

        invoice_attachments::create([
            'file_name'=> $file_name,
            'invoice_number'=> $request->invoice_number,
            'invoice_id'=> $request->invoice_id,
            'Created_by'=>Auth::user()->name
        ]);
        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoice_attachments $invoice_attachments)
    {
        //
    }
}
