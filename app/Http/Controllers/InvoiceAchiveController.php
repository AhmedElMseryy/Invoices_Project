<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class InvoiceAchiveController extends Controller
{
    ##-------------------------------------------------------INDEX
    public function index()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('Invoices.Archive_Invoices', compact('invoices'));
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
    public function show(string $id)
    {
        //
    }

    ##-------------------------------------------------------EDIT
    public function edit(string $id)
    {
        //
    }

    ##-------------------------------------------------------UPDATE
    public function update(Request $request)
    {
        $id = $request->invoice_id;
        $flight = Invoices::withTrashed()->where('id', $id)->restore();
        session()->flash('restore_invoice');
        return redirect('/invoices');
    }

    ##-------------------------------------------------------DELETE
    public function destroy(Request $request)
    {
        $invoices = invoices::withTrashed()->where('id', $request->invoice_id)->first();
        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/Archive');
    }
}
