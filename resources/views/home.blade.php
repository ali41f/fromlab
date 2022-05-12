@extends('layouts.admin1')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card lab-container">
                    <div class="card-header">
                        Dashboard
                    </div>
                    <div class="container-fluid">
                        <div class="row mt-2 widgets">
                            <div class="col-md-3 col-sm-6 py-2">
                                <div class="card card-1 text-white h-100">
                                    <div style="background-color:rgb(0,200,255);" class="card-body card-1">

                                        <i class="mr-2 fa fa-hospital-o" style="font-size:48px;"></i>

                                        <h5 class="mb-3 d-inline-block">Today Verified Tests</h5>
                                        <h3 class="amount-position"> {{ $today }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 py-2">
                                <div class="card card-1 text-white h-100">
                                    <div style="background-color:rgb(50,150,255);" class="card-body card-1">
                                        <i class="mr-2 fa fa-user-md" style="font-size:48px;"></i>
                                        <h5 class="mb-3 d-inline-block">Weekly Verified Tests</h5>
                                        <h3 class="amount-position"> {{ $thisWeekPatient }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 py-2">
                                <div class="card card-1 text-white h-100">
                                    <div style="background-color:rgb(200,150,255);" class="card-body card-1">
                                        <i class="mr-2 fa fa-stethoscope" style="font-size:48px;"></i>
                                        <h5 class="mb-3 d-inline-block">Monthly Verified Tests </h5>
                                        <h3 class="amount-position"> {{ $thisMongthPatient }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 py-2">
                                <div class="card card-1 text-white h-100">
                                    <div style="background-color:rgb(200,50,90);;" class="card-body card-1">
                                        <i class="mr-2 fa fa-wheelchair" style="font-size:48px;color:white"></i>
                                        <h5 class="mb-3 d-inline-block">Critical Tests Today</h5>
                                        <h3>{{ count($criticalTestToday) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-1 mb-4">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h2>Critical Today </h2>
                                
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <h2>Delayed</h2>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            $('.datatable-Event:not(.ajaxTable)').DataTable({
                "paging": false,
                "info": false
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection