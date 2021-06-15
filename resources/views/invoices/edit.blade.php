@extends('layout')

@section('javascript')
    <script>
        $('#add-item').click(function() {
            var count = $("#items-content tr").length;
            var id = $("#inputItems option:selected").data("id"),
                type = $("#inputItems option:selected").data("type"),
                price = $("#inputItems option:selected").data("price"),
                description = $("#inputItems option:selected").data("description"),
                quantity = parseFloat($("#inputQuantity").val());
            if (quantity == 0) {
                alert('Quantity must be larger than 0');
                return;
            }
            if (quantity > 1000000) {
                alert('Maximum Item Quantity is 1000000')
            }
            if (product_id != 0 && !isNaN(quantity) && (quantity > 0 && quantity <= 1000000)) {
                $("#items-content").append(`<tr id="row_${count}" data-product="${product_id}" data-qty="${quantity}">
                    <td>${count + 1}</td>
                    <td class="row_${count}_item">
                        <input type="hidden" name="data[${count}][product_id]" value="${product_id}">
                        <span>${item_name}</span>
                    </td>
                    <td class="row_${count}_qty">
                        <input type="hidden" name="data[${count}][quantity]" value="${quantity}">
                        <span>${quantity}</span>
                    </td>
                    <td class="row_${count}_total">${price_sell * quantity}</td>
                    <td>
                        <button type="button" data-row="${count}" data-edit="row_${count}" class="btn btn-primary edit-row">
                            <i class="fa fa-edit"></i> Edit
                        </button>

                        <button type="button" data-delete="row_${count}" class="btn btn-danger delete-row">
                            <i class="fa fa-times"></i> Remove
                        </button>
                    </td>
                `);
                $("#product_id").val("");
                $("#quantity").val("")
                $('.select2').trigger('change.select2');
                $("#submit").attr('disabled', false)   
            }
        });
    </script>
@endsection

@section('content')
<h2 class="my-3">Edit Invoice {{ $invoice->number }}</h2>
<div class="row mb-3">
    <div class="col">
        <a class="btn btn-secondary" href="{{ route('invoice.index') }}">See all Invoices</a>
    </div>
</div>
<form method="POST" action="{{ route('invoice.update', $invoice->id) }}">
    @csrf
    @method('PUT')
    <div class="row mb-3">
        <label for="inputNumber" class="col-sm-2 col-form-label">Invoice Number <sup class="text-danger">*</sup></label>
        <div class="col-sm-10">
            <input type="text" name="number" value="{{ $invoice->number }}" class="form-control" id="inputNumber">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputClient" class="col-sm-2 col-form-label">Client <sup class="text-danger">*</sup></label>
        <div class="col-sm-10">
            <select class="form-select" aria-label="Default select example" id="inputClient" name="client_id">
                @foreach ($clients as $client)
                    <option {{ $invoice->client_id == $client->id ? 'selected' : '' }} value="{{ $client->id }}">{{ $client->name }}</option>    
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputPaid" class="col-sm-2 col-form-label">Paid off</label>
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" value="1" name="is_paid" type="checkbox" id="gridCheck1">
                <label class="form-check-label" for="gridCheck1">
                    Yes
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputIssueDate" class="col-sm-2 col-form-label">Issue Date <sup class="text-danger">*</sup></label>
        <div class="col-sm-10">
            <input type="date" name="issue_date" value="{{ $invoice->issue_date }}" class="form-control" id="inputIssueDate">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputDueDate" class="col-sm-2 col-form-label">Due Date <sup class="text-danger">*</sup></label>
        <div class="col-sm-10">
            <input type="date" name="due_date" value="{{ $invoice->due_date }}" class="form-control" id="inputDueDate">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputSubject" class="col-sm-2 col-form-label">Subject <sup class="text-danger">*</sup></label>
        <div class="col-sm-10">
            <textarea name="subject" id="inputSubject" cols="30" rows="10" class="form-control">{{ $invoice->subject }}</textarea>
        </div>
    </div>
    <div class="row mb-3">
        <table class="table table-striped caption-top">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Unit Price</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody id="items-content">
                @foreach ($details as $detail)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $detail->item->type }}</td>
                    <td>{{ $detail->item->description }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $detail->item->price }}</td>
                    <td>{{ $detail->quantity * $detail->item->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection