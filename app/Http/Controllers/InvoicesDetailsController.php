<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\invoices;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class InvoicesDetailsController extends Controller
{
    ##-------------------------------------------------------INDEX
    public function index()
    {
        //
    }

    ##-------------------------------------------------------CREATE
    public function create()
    {
        //
    }

    ##-------------------------------------------------------STORE
    public function store(Request $request)
    {
        //
    }

    ##-------------------------------------------------------SHOW
    public function show(invoices_details $invoices_details)
    {
        //
    }

    ##-------------------------------------------------------EDIT
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $details = invoices_details::where('id_Invoice', $id)->get();
        $attachment = invoice_attachments::where('invoice_id', $id)->get();

        return view('invoices.invoiceDetails', compact('invoices', 'details', 'attachment'));
    }

    ##-------------------------------------------------------UPDATE
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    ##-------------------------------------------------------DELETE
    public function destroy(Request $request)
    {
        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    ##-------------------------------------------------------open_file
    public function open_file($invoice_number, $file_name)

    {
        $files = Storage::disk('public')->get($invoice_number . '/' . $file_name);

        if (!Storage::disk('public')->exists($invoice_number . '/' . $file_name)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->file($files);
    }

    ##-------------------------------------------------------get_file
    public function get_file($invoice_number, $file_name)

    {

        $contents = Storage::disk('public')->get($invoice_number . '/' . $file_name);

        return response()->download($contents);
    }
}
