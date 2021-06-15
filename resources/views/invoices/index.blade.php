@extends('layout')
@section('content')
    <div class="row my-3">
        <div class="col-6">
            <a href="{{ route('invoice.create') }}" class="btn btn-success">Add new Invoice</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped caption-top">
                <caption>List of invoices</caption>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Amount Due</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Paid off</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $invoice->number }}</td>
                        <td>{{ $invoice->client->name }}</td>
                        <td>
                            @php
                                $totalAmount = 0;
                            @endphp
                            @foreach($invoice->details as $details)
                                @php
                                    $totalAmount += ($details->quantity * $details->item->price)
                                @endphp
                            @endforeach
                            @php
                                $totalAmount += $totalAmount * (10/100)
                            @endphp
                            {{ $totalAmount }}
                        </td>
                        <td>{{ $invoice->due_date }}</td>
                        <td>{{ $invoice->is_paid ? 'YES' : 'NO' }}</td>
                        <td>
                            <a href="{{ route('invoice.show', $invoice->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-warning">Edit</a>
                            <form style="display: inline" action="{{ route('invoice.destroy', $invoice->id) }}" method="post" onclick="return confirm('Are you sure you want to delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection