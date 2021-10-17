@extends('layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('invoice.index') }}" method="get" class="form">
                <div class="row">
                    <div class="col-3">
                        <input class="form-control daterange" type="text" name="daterange" value="{{ $start_date }} to {{ $end_date }}" />
                    </div>
                    <div class="col-1">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="row my-3">
                <div class="col-6">
                    <a href="{{ route('invoice.create') }}" class="btn btn-success">Add new Invoice</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped caption-top dataTables">
                        <caption>List of invoices</caption>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Amount Due</th>
                                <th scope="col">Issue Date</th>
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
                                <td>{{ $invoice->issue_date }}</td>
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
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div id="bar-chart">

                    </div>
                </div>
                <div class="col-12">
                    <div id="pie-chart">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        // dd($categories);   
    @endphp
@endsection

@section('javascript')
    <script>
        $('input.daterange').daterangepicker({
            autoUpdateInput: false,
            locale: {
                "format": "YYYY-MM-DD",
                cancelLabel: 'Clear',
                "separator": " to ",
            }
        });
    </script>

    <script>
        Highcharts.chart('bar-chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Invoice'
            },
            xAxis: {
                categories: {{ $categoriesBarChart }},
                crosshair: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Invoice Issued',
                data: {{ $dataInvoiceIssued }}

            }]
        });
        Highcharts.chart('pie-chart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Invoice Paid Off'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: {!! $dataInvoiceIsPaid !!}
            }]
        });
    </script>
@endsection