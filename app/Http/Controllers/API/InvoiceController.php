<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('details', 'details.item', 'client')->get();
        $closure = [
            'count' => count($invoices),
            'data' => $invoices
        ];
        return response()->json($closure, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::with('details', 'details.item', 'client')->find($id);
        if (!$invoice) {
            $closure = [
                'message' => 'Invoice not found !'
            ];
            return response()->json($closure, 404);        
        }
        $closure = [
            'data' => $invoice
        ];
        return response()->json($closure, 200);
    }
}
