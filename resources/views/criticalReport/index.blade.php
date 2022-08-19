@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Critical Reports
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('criticalReportProcess') }}" enctype="multipart/form-data">
                @csrf


                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="initialtime">Initial Time</label>
                            <input class="form-control {{ $errors->has('initialtime') ? 'is-invalid' : '' }}" type="datetime-local" name="initialtime" id="initialtime" value="{{ $initialtime ?? '' }}">

                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="finaltime">Final Time</label>
                            <input class="form-control {{ $errors->has('finaltime') ? 'is-invalid' : '' }}" type="datetime-local" name="finaltime" id="finaltime" value="{{ $finaltime ?? '' }}">

                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="initialtime">Test name</label>
                            <input class="form-control {{ $errors->has('testname') ? 'is-invalid' : '' }}" type="text" name="testname" id="testname" value="{{ $testname ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="initialtime">Ref by</label>
                            <input class="form-control {{ $errors->has('ref') ? 'is-invalid' : '' }}" type="text" name="ref" id="ref" value="{{ $ref ?? '' }}">
                        </div>
                    </div>
                </div>


                <button class="btn btn-primary" type="submit">Get Data</button>
            </form>

        </div>
    </div>
    @if(isset($testPerformeds))
        <div class="card">
            <div class="card-header">
                List of tests
            </div>
            @php $totalFee = 0; @endphp
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                        <thead>
                        <tr>
                            <th>
                                Date
                            </th>
                            <th>
                                Patient Name
                            </th>
                            <th>
                                Test Name
                            </th>
                            <th>
                                Result
                            </th>
                            <th>
                                Contact
                            </th>
                            <th>
                                Informed to
                            </th>
                            <th>
                                Informed by
                            </th>
                            <th>
                                Time
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($testPerformeds as $key => $testPerformed)
                            {{--                            @php $totalFee = $totalFee + $testPerformed->fee; @endphp--}}
                            <tr data-entry-id="{{ $testPerformed->id }}">
                                <td>
                                    {{ $testPerformed->receive_time ?? '' }}
                                </td>
                                <td>
                                    {{ $testPerformed->Pname ?? '' }} ({{ $testPerformed->patient_id ?? '' }}) {{ \Carbon\Carbon::parse($testPerformed->dob)->diff(\Carbon\Carbon::now())->format('%y year(s)') ?? '' }} {{$testPerformed->gend}}
                                </td>
                                <td>
                                    {{ $testPerformed->report_item_title ?? '' }}
                                </td>
                                <td>
                                    {{ $testPerformed->value ?? '' }}
                                </td>
                                <td>
                                    {{ $testPerformed->phone ?? '' }}
                                </td>
                                <td>
                                    {{ $testPerformed->informed_to ?? '' }}
                                </td>
                                <td>
                                    {{ $testPerformed->informed_by ?? '' }}
                                </td>
                                <td>
                                    {{ $testPerformed->created_at ?? '' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{--        <div class="card">--}}
        {{--            <div class="card-header">--}}
        {{--                Total Fee: Rs {{$totalFee}}--}}
        {{--            </div>--}}
        {{--        </div>--}}
    @endif


    <script type="text/javascript">

        function searchTable() {
            console.log("search funtion");
            // Setup - add a text input to each footer cell
            $('.datatable thead tr').clone(true).appendTo('.datatable thead');

            $('.datatable thead tr:eq(1) th').each(function (i) {
                if (i == 1 || i == 2 || i == 4 || i == 3) {
                    var title = $(this).text();
                    $(this).html('<input type="text" style="width:100%;" placeholder="Search" />');
                    $('input', this).on('keyup change', function () {
                        if (table.column(i).search() !== this.value) {
                            table.column(i).search(this.value).draw();
                        }
                    });
                } else {
                    $(this).html('');
                }
            });

        }

        $(function () {

            //searchTable();


            let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
            let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
            let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
            let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
            let printButtonTrans = '{{ trans('global.datatables.print') }}'
            let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
            let selectAllButtonTrans = '{{ trans('global.select_all') }}'
            let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

            $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {className: 'btn'})
            $.extend(true, $.fn.dataTable.defaults, {
                columnDefs: [{
                    orderable: false,
                    searchable: true,
                    targets: -1
                }],
                select: {
                    style: 'multi+shift',
                    selector: 'td:first-child'
                },
                order: [],
                scrollX: true,
                pageLength: 100,
                dom: 'lBfrtip<"actions">',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn-default',
                        text: copyButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn-default',
                        text: csvButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-default',
                        text: excelButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-default',
                        title: 'Critical Results Summary',
                        text: pdfButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function ( pdf, btn, tbl ) {
                            console.log(pdf);
                            // delete pdf.styles.tableBodyOdd.fillColor;
                            // delete pdf.styles.tableHeader.fillColor;
                            // pdf.styles.tableHeader.color='black';
                            // pdf.styles.tableHeader.border='2px solid black';
                           delete pdf.styles.tableBodyOdd.fillColor;

                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-default',
                        text: printButtonTrans,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                ]
            });

            table = $('.datatable').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                "order": [[0, "desc"]],
                "pageLength": 25,
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>

@endsection