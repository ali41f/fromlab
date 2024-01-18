<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\TestPerformed;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sendfromlocal', function(Request $request) {
    
    $img = $request->image;
    $mrid = $request->mrid;
    $phone = $request->phone;
    $patientname = $request->patientname;
    $imagepath = $request->imagepath;


    // $png_url = $mrid.time().".jpg";
    // $path = public_path() . "/" . $png_url;
    // $img = substr($img, strpos($img, ",")+1);
    // $data = base64_decode($img);
    // $success = file_put_contents($path, $data);

    date_default_timezone_set('Asia/Karachi');



 
    $url = "http://mywhatsapp.pk/api/send.php";
     
    $parameters = array("api_key" => "923253411392-a89d3d6f-1e62-4944-8b61-e42423e079b5",
                        "mobile" => $phone,
                        "message" => "Dear ".$patientname.",\n\nYour lab report from Usama Laboratory is available online at ".$imagepath."\nYour patient ID is ".$mrid.". Please remember to mention this ID whenever you visit Usama laboratory. \n \nBest Regards,\nUsama Laboratory",
                        "priority" => "0",
                        "type" => 0
                        );
                        
    $parameters2 = array("api_key" => "923253411392-a89d3d6f-1e62-4944-8b61-e42423e079b5",
                        "mobile" => $phone,
                        "priority" => "0",
                        "type" => 1,
                        "url" => $imagepath
                        );
     
    $ch = curl_init();
    $timeout  =  30;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $response = curl_exec($ch);
    
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters2);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $response2 = curl_exec($ch);
    curl_close($ch);

    $testslist = $request->testslist;
     TestPerformed::whereIn('id', $testslist)
        ->update([
            'sms' => 'sent',
        ]);
    
    return $response2;
});

Route::post('/smsstatus', function(Request $request) {
    $testslist = $request->testslist;

    TestPerformed::whereIn('id', $testslist)
        ->update([
            'sms' => 'sent',
        ]);

    return 'done';

});