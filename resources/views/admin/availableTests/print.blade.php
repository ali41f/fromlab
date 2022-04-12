@extends('layouts.admin')
@section('content')
    
    <div class="card">
        <div class="card-header">
            <h2>Usama Laboratory Charge Sheet</h2>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                    <thead>
                    <tr>
                    
                        <th>
                            Category
                        </th>
                        <th>
                            Test name
                        </th>
                        <th>
                            Test Fee
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($availableTests as $key => $availableTest)
                        <tr data-entry-id="{{ $availableTest->id }}">
                            
                            <td>
                                {{ $availableTest->category->Cname ?? '' }}
                            </td>
                            <td>
                                {{ $availableTest->name ?? '' }}
                            </td>
                            <td>
                                {{ $availableTest->testFee ?? '' }}
                            </td>

                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection