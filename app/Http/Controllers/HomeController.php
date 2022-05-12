<?php

namespace App\Http\Controllers;

use App\Models\AvailableTest;
use App\Models\TestPerformed;
use App\Models\Category;
use App\Models\TestReport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $todayDate = Carbon::today();
        $data = DB::table('test_performeds')->where('status', '=', 'verified')->get();
        $today = $data->where('created_at', '>=', $todayDate)->count();
        $thisWeekPatient = $data->where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $thisMongthPatient = $data->where('created_at', '>=', Carbon::now()->subDays(30))->count();       

            //dd($allPerformedToday);

        $ids_added_as_critical = array();
        $criticalTestToday = array();
        
        //dd($ids_added_as_critical); 
        $todayDelayeds = TestPerformed::where([
            ['created_at', '>=', $todayDate],
            ['status', '!=', 'verified'],
            ['status', '!=', 'cancelled'],
        ])->latest()->get();
        $testPerformeds = TestPerformed::where('created_at', '>=', $todayDate)->get();
        $availableTestNameAndCountTests = AvailableTest::withCount(['testPerformed'])
            ->orderBy('test_performed_count', 'desc')
            ->get();
        $test = DB::table('test_performeds')
            ->get('id');
        $distincrCatagory2 = $test->count();
        $distincrCatagory = Category::distinct()->get();
        $test = DB::table('test_performeds')
            ->get('id');
        $distincrCatagory2 = $test->count();
        return view('home', compact('today', 'thisWeekPatient', 'thisMongthPatient',
            'distincrCatagory2', 'todayDelayeds', 'criticalTestToday', 'testPerformeds', 'availableTestNameAndCountTests'));
    }
}