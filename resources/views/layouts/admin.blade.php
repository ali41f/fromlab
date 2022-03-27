<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="stripe-key" content="{{ config('cashier.key') }}">
    <title>Usama Laboratory</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/all.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/select.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/coreui.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/dropzone.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-duration-picker.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    @yield('styles')
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">
    <header class="app-header navbar">
        <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <span class="navbar-brand-full">Usama Laboratory</span>
            <span class="navbar-brand-minimized">Usama Laboratory</span>
        </a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="ml-auto mr-5">{{Auth::user()->name}}</div>
        
    </header>
    <div class="app-body">
        @include('partials.menu')
        <main class="main">
            <div style="padding-top: 20px" class="container-fluid">
                @if(session('message'))
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                @endif
                @if($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
    <!-- <script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script> -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/coreui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/bootstrap-duration-picker.js') }}"></script>
    <script src="{{ asset('js/bootstrap-duration-picker-debug.js') }}"></script>


    <script>

    var table=""; 
    $('#duration').durationPicker();
    $('#duration2').durationPicker();
    

    
    $(function() {

        let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
        let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
        let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
        let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
        let printButtonTrans = '{{ trans('global.datatables.print') }}'
        let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
        let selectAllButtonTrans = '{{ trans('global.select_all') }}'
        let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'
        
        $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, { className: 'btn' })
        $.extend(true, $.fn.dataTable.defaults, {
          columnDefs: [{
              orderable: false,
              className: 'select-checkbox',
              targets: 0
          }, {
              orderable: false,
              searchable: true,
              targets: -1
          }],
          select: {
            style:    'multi+shift',
            selector: 'td:first-child'
          },
          order: [],
          scrollX: true,
          pageLength: 100,
          dom: 'lBfrtip<"actions">',
          buttons: [
            {
              extend: 'selectAll',
              className: 'btn-primary',
              text: selectAllButtonTrans,
              exportOptions: {
                columns: ':visible'
              }
            },
            {
              extend: 'selectNone',
              className: 'btn-primary',
              text: selectNoneButtonTrans,
              exportOptions: {
                columns: ':visible'
              }
            },
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
              text: pdfButtonTrans,
              exportOptions: {
                columns: ':visible'
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
            {
              extend: 'colvis',
              className: 'btn-default',
              text: colvisButtonTrans,
              exportOptions: {
                columns: ':visible'
              }
            }
          ]
        });

        $.fn.dataTable.ext.classes.sPageButton = '';
      });
    
    </script>
    @yield('scripts')
</body>
</html>