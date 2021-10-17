@extends('layout')

@section('javascript')
    <script>
        $('#add-item').click(function() {
            var count = $("#items-content tr").length;
            var item_id = $("#inputItems option:selected").data("id"),
                type = $("#inputItems option:selected").data("type"),
                price = $("#inputItems option:selected").data("price"),
                description = $("#inputItems option:selected").data("description"),
                quantity = parseFloat($("#inputQuantity").val());
                console.log(quantity);
            if (quantity == 0 || isNaN(quantity)) {
                alert('Quantity must be larger than 0');
                return;
            }
            if (item_id == 0 || isNaN(item_id)) {
                alert('Item must be selected');
                return;
            }
            if (quantity > 1000000) {
                alert('Maximum Item Quantity is 1000000')
            }
            if (item_id != 0 && (quantity > 0 && quantity <= 1000000)) {
                $("#items-content").append(`<tr id="row_${count}">
                    <input type="hidden" name="details[${count}][item_id]" value="${item_id}">
                    <input type="hidden" name="details[${count}][quantity]" value="${quantity}">
                    <td>${count + 1}</td>
                    <td class="row_${count}_type">
                        <span>${type}</span>
                    </td>
                    <td class="row_${count}_description">
                        <span>${description}</span>
                    </td>
                    <td class="row_${count}_quantity">
                        <span>${quantity}</span>
                    </td>
                    <td class="row_${count}_price">
                        <span>${price}</span>
                    </td>
                    <td class="row_${count}_total">${price * quantity}</td>
                    <td>
                        <button type="button" data-delete="row_${count}" class="btn btn-danger delete-row">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </td>
                `);
                $("#inputItems").val("");
                $("#inputQuantity").val("")
            }
        });

        $("#items-content").on("click", "button.delete-row", function(){
            var data = $(this).data("delete");
            $(`#${data}`).remove();
            for (var datas in json_post) delete json_post[datas];
            $("#items-content tr").attr("id", "")
            $('#items-content tr').each(function(count, item){
                $this = $(item);
                $(this).attr("id",`row_${count}`);
                $(this).children("td").first().text(count+1);
                $(this).children("td").last().html(`
                    <button type="button" data-delete="row_${count}" class="btn btn-danger delete-row">
                        <i class="bi bi-x-lg"></i>
                    </button>
                `)
            });
        })
    </script>
@endsection

@section('content')
<h2 class="my-3">Create Invoice</h2>
<div class="row mb-3">
    <div class="col">
        <a class="btn btn-secondary" href="{{ route('invoice.index') }}">See all Invoices</a>
    </div>
</div>
<form method="POST" action="{{ route('invoice.store') }}">
    @csrf
    <div class="row mb-3">
        <label for="inputNumber" class="col-sm-2 col-form-label">Invoice Number <sup class="text-danger">*</sup></label>
        <div class="col-sm-10">
            <input type="text" value="{{ old('number') }}" name="number" class="form-control" id="inputNumber">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputClient" class="col-sm-2 col-form-label">Client <sup class="text-danger">*</sup></label>
        <div class="col-sm-10">
            <select class="form-select" aria-label="Default select example" id="inputClient" name="client_id">
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>    
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
            <input type="date" value="{{ old('issue_date') }}" name="issue_date" class="form-control" id="inputIssueDate">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputDueDate" class="col-sm-2 col-form-label">Due Date <sup class="text-danger">*</sup></label>
        <div class="col-sm-10">
            <input type="date" value="{{ old('due_date') }}" name="due_date" class="form-control" id="inputDueDate">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputSubject" class="col-sm-2 col-form-label">Subject <sup class="text-danger">*</sup></label>
        <div class="col-sm-10">
            <textarea name="subject" id="inputSubject" cols="30" rows="10" class="form-control">{{ old('subject') }}</textarea>
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputItems" class="col-sm-2 col-form-label">Items</label>
        <div class="col-sm-9 mb-2">
            <select class="form-select" id="inputItems">
                <option>Select item</option>
                @foreach ($items as $item)
                    <option 
                        data-id="{{ $item->id }}" 
                        data-type="{{ $item->type }}" 
                        data-price="{{ $item->price }}" 
                        data-description="{{ $item->description }}"
                    >
                        {{ $item->type }} - {{ $item->description }}
                    </option>    
                @endforeach
            </select>
        </div>
        <div class="col-sm-9 offset-2">
            <input type="number" min="1" max="1000000" id="inputQuantity" class="form-control" placeholder="Quantity">
        </div>
        <div class="col-sm-1">
            <button id="add-item" type="button" class="btn btn-success"><i class="bi bi-plus-lg"></i></button>
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
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="items-content">
            </tbody>
        </table>
    </div>


    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection