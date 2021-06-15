<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Client;
use App\Models\Item;
use Illuminate\Http\Request;
use Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view("invoices.index", [
            "invoices" => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients    = Client::all();
        $items      = Item::all();
        return view("invoices.create", [
            "clients" => $clients,
            "items"   => $items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "number" => "required",
                "issue_date" => "required",
                "due_date" => "required",
                "subject" => "required",
                "client_id" => "required",
            ],
            [
                "number.required" => "Invoice number : required",
                "issue_date.required" => "Issue date : required",
                "due_date.required" => "Due date : required",
                "subject.required" => "Subject : required",
                "client_id.required" => "Client : required"
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $invoice = Invoice::create([
            "number" => $request->number,
            "issue_date" => $request->issue_date,
            "due_date" => $request->due_date,
            "subject" => $request->subject,
            "client_id" => $request->client_id,
            "is_paid" => $request->is_paid ?? false,
        ]);

        foreach ($request->details as $key => $detail) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'item_id' => $detail['item_id'],
                'quantity' => $detail['quantity']
            ]);
        }
        return redirect()->route('invoice.index')->with('success', "Invoice $invoice->number has been added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view("invoices.show", [
            "invoice" => $invoice,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $details    = InvoiceDetail::where('invoice_id', $invoice->id)->get();
        $clients    = Client::all();
        $items      = Item::all();
        return view("invoices.edit", [
            "invoice" => $invoice,
            "details" => $details,
            "clients" => $clients,
            "items"   => $items,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update([
            "number" => $request->number,
            "issue_date" => $request->issue_date,
            "due_date" => $request->due_date,
            "subject" => $request->subject,
            "client_id" => $request->client_id,
            "is_paid" => $request->is_paid ?? false,
        ]);
        return redirect()->route('invoice.index')->with('success', "Invoice $invoice->number has been edited successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $number = $invoice->number;
        $invoice->delete();
        return redirect()->route('invoice.index')->with('success', "Invoice $number has been deleted successfully");
    }
}
