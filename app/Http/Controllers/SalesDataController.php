<?php

namespace App\Http\Controllers;

use App\Models\AvailableTest;
use App\Models\TestPerformed;
use App\Models\Category;
use App\Models\TestReport;
use Carbon\Carbon;
use App\Models\Patient;
use Illuminate\Http\Request;
use DB;
use function PHPUnit\Framework\isEmpty;

class SalesDataController extends Controller
{
    public function index()
    {
        return view('sales.index');

    }

    public function getDataBetweenTime(Request $request)
    {
        $initialtime = $request->initialtime;
        $finaltime = $request->finaltime;
        $testname = $request->testname;
        $ref = $request->ref;
        $testPerformeds = TestPerformed::join('patients', 'test_performeds.patient_id', '=', 'patients.id')
            ->join('available_tests', 'test_performeds.available_test_id', '=', 'available_tests.id')
            ->where('available_tests.name', 'like', '%' . $testname)
            ->where('test_performeds.referred', 'like', '%' . $ref)
            ->select('test_performeds.*', 'patients.Pname', 'patients.id as Pid', 'available_tests.name',
                'available_tests.testFee', 'test_performeds.specimen')
            ->whereBetween('test_performeds.created_at', [$initialtime, $finaltime])->get();

        return view('sales.index', compact('testPerformeds', 'initialtime', 'finaltime', 'testname', 'ref'));
    }

    public function criticalReport()
    {
        return view('criticalReport.index');
    }

    public function criticalReportProcess(Request $request)
    {
        $initialtime = $request->initialtime;
        $finaltime = $request->finaltime;
        $testname = $request->testname;
        $ref = $request->ref;

        $critical_reports = TestReport::join('test_report_items', 'test_report_items.id', '=', 'test_reports.test_report_item_id')
            ->join('available_tests', 'test_report_items.test_id', '=', 'available_tests.id')
            ->join('test_performeds', 'test_performeds.id', '=', 'test_reports.test_performed_id')
            ->join('patients', 'test_performeds.patient_id', '=', 'patients.id')
            //            ->where('test_reports.value','REGEXP','^[0-9]')
            //            ->where('test_reports.value','<=','test_report_items.firstCriticalValue')
            //            ->Where('test_reports.value','>=','test_report_items.finalCriticalValue')
            ->whereNotNull('value')
            ->select('test_reports.*', 'patients.Pname', 'patients.gend', 'patients.phone', 'patients.dob', 'patients.id as patient_id', 'available_tests.name as test_name',
                'available_tests.testFee', 'test_performeds.specimen','test_performeds.informed_to','test_performeds.informed_by', 'test_performeds.created_at as receive_time', 'test_report_items.firstCriticalValue',
                'test_report_items.finalCriticalValue','test_report_items.title as report_item_title');

        if (!is_null($initialtime)) {
            $critical_reports = $critical_reports->where('test_performeds.created_at', '>=', $initialtime);
        }
        if (!is_null($finaltime)) {
            $critical_reports = $critical_reports->where('test_performeds.created_at', '<=', $finaltime);
        }
        if (!is_null($testname)) {
            $critical_reports = $critical_reports->where('available_tests.name', 'like', '%' . $testname);
        }
        if (!is_null($ref)) {
            $critical_reports = $critical_reports->where('test_performeds.referred', 'like', '%' . $ref);
        }


        $critical_reports = $critical_reports->orderBy('id', 'DESC')
            ->limit(50000)
            ->get();


        $critical_reports = $critical_reports->whereNotNull('numeric_value')

            ->where("is_critical","1")

//            ->where('numeric_value', '<=', 'first_critical_value_float')->merge($critical_reports->where('numeric_value', '>=', 'test_report_items.finalCriticalValue'))
//            ->take(1000)
        ;
//        $index=775844;
//                dd(
//                    $critical_reports[$index]->firstCriticalValue,
//                    $critical_reports[$index]->finalCriticalValue,
//                    $critical_reports[$index]->numeric_value,
//                    $critical_reports[$index]->value,
//                    $critical_reports[$index]->numeric_value<=$critical_reports[$index]->firstCriticalValue,
//                    $critical_reports[$index]->numeric_value>=$critical_reports[$index]->finalCriticalValue,
//                    $critical_reports[$index],

//                    $critical_reports->take(10)
//                );

        $testPerformeds = $critical_reports->take(500);


        return view('criticalReport.index', compact('testPerformeds', 'initialtime', 'finaltime', 'testname', 'ref'));
    }
}