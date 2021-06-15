@extends('layout')
@section('content')
    <div class="row my-5">
        <div class="col-6">
            <a href="{{ route('invoice.index') }}" class="btn btn-secondary">See All Invoices</a>
        </div>
        <div class="col-6">
            <button onclick="window.print()" class="float-end btn btn-secondary">Print</button>
            <button disabled class="float-end btn btn-secondary">PDF</button>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-4">
            <h1 class="text-uppercase">Invoice</h1>
        </div>
        <div class="col-4">
            @if ($invoice->is_paid)
                <img src="{{ asset('paid.png') }}" alt="" srcset="" class="w-25">
            @endif
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-4">
                    <p>From</p>
                </div>
                <div class="col-8">
                    <div class="callout">
                        <span class="d-block"><strong>Discovery Designs</strong></span>
                        <span class="d-block">41 St Vincent Place</span>
                        <span class="d-block">Glasgow G1 2ER</span>
                        <span class="d-block">Scotland</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-4">
            <div class="row">
                <div class="col-4">
                    <span class="d-block">InvoiceID</span>
                    <span class="d-block">Issue Date</span>
                    <span class="d-block">Due Date</span>
                    <span class="d-block">Subject</span>
                </div>
                <div class="col-8">
                    <div class="callout">
                        <span class="d-block">{{ $invoice->number }}</span>
                        <span class="d-block">{{ $invoice->issue_date }}</span>
                        <span class="d-block">{{ $invoice->due_date}}</span>
                        <span class="d-block">{{ $invoice->subject}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-4">
                    <p>For</p>
                </div>
                <div class="col-8">
                    <div class="callout">
                        <span class="d-block"><strong>{{ $invoice->client->name }}</strong></span>
                        <span class="d-block">{{ $invoice->client->address }}</span>
                        <span class="d-block">{{ $invoice->client->city}} {{ $invoice->client->post_code }}</span>
                        <span class="d-block">{{ $invoice->client->country}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped caption-top">
                <thead>
                    <tr>
                        <th scope="col">Item Type</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody id="items-content">
                    @php
                        $totalAmount = 0;
                    @endphp
                    @foreach ($invoice->details as $detail)
                    @php
                        $totalAmount += ($detail->quantity * $detail->item->price)
                    @endphp
                    <tr>
                        <td>{{ $detail->item->type }}</td>
                        <td>{{ $detail->item->description }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ $detail->item->price }}</td>
                        <td>{{ $detail->quantity * $detail->item->price }}</td>
                    </tr>
                    @endforeach
                    @php
                        $tax    = $totalAmount * (10/100);
                    @endphp
                </tbody>
                <tfoot class="border-white">
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-end">Sub Total</td>
                        <td class="fw-bold">{{ $totalAmount }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-end">Tax (10%)</td>
                        <td class="fw-bold">{{ $tax }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-end">Payments</td>
                        <td class="fw-bold">{{ $invoice->is_paid ? 0 - ($totalAmount + $tax) : 0 }}</td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td colspan="3"></td>
                        <td class="text-end"><h4>Amount Due</h4></td>
                        <td class="fw-bold">{{ !$invoice->is_paid ? $totalAmount + $tax : 0 }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection