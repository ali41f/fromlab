<style>
.row {
  display: flex; /* equal height of the children */
}

.col {
  flex: 1; /* additionally, equal width */
  
  padding: 1em;
  /* border: solid gray; */
}

.hr {
    border-top: 2px solid red;
}
.h12 {
  background-color: #ddd;
  text-align:center;
  padding: 5px;
}
.capitalize{
    text-transform: capitalize;
}
</style>
<div>
    
    <div class="report_detail">
        <div class="row">
            <div class="col-sm-7">
                <table class="table-borderless">
                    <tr>
                        <td width="140">Patient's Name</td>
                        <td><strong class="patientname" patientname="{{ $getpatient->Pname }}">{{ $getpatient->Pname }}</strong></td>
                    </tr>
                    <tr>
                        <td width="140">Age / Gender</td>
                        <td><strong>{{ \Carbon\Carbon::parse($getpatient->dob)->diff(\Carbon\Carbon::now())->format('%y') ? \Carbon\Carbon::parse($getpatient->dob)->diff(\Carbon\Carbon::now())->format('%y years') : \Carbon\Carbon::parse($getpatient->dob)->diff(\Carbon\Carbon::now())->format('%m months %d days') }} / <span class="capitalize">{{ $getpatient->gend }}</span></strong></td>
                    </tr>
                    <tr>
                        <td width="140">Cell #</td>
                        <td><strong class="phonenum" phone="{{$getpatient->phone}}">{{ $getpatient->phone }}</strong></td>
                    </tr>
                    <tr>
                        <td width="140">Ref by</td>
                        <td><strong>{{ $testPerformedsId->referred != '' ? $testPerformedsId->referred : "Self"}}</strong></td>
                    </tr>
                   
                </table>
            </div>
            <div class="col-sm-5">
                <table class="table-borderless">
                    <tr>
                        <td width="140">MR ID</td>
                        <td><strong class="patientmrid" mrid="{{$getpatient->id}}">{{ $getpatient->id }}</strong></td>
                    </tr>
                    <tr>
                        <td width="140">LAB No.</td>
                        <td><strong>{{$testPerformedsId->specimen}}</strong></td>
                    </tr>
                    <tr>
                        <td width="140">Ordered Date</td>
                        <td><strong>{{ date('d-m-Y H:i:s', strtotime($testPerformedsId->created_at)) }}</strong></td>
                    </tr>
                    <tr>
                        <td width="140">Report Date</td>
                        <td><strong>{{ date('d-m-Y H:i:s', strtotime($testPerformedsId->updated_at)) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


</div>
