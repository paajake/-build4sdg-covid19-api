<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estimator;
use App\AccessLog;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function json(Request $request){
        $validatedData = $this->validator($request);
        $estimated_results = (new Estimator())->covid19ImpactEstimator($validatedData);

        return response($estimated_results, 200)
            ->header('Content-Type', "application/json");
    }

    public function xml(Request $request){
        $validatedData = $this->validator($request);
        $estimated_results = (new Estimator())->covid19ImpactEstimator($validatedData);

        return response()->xml($estimated_results, $status = 200,
                            $headers = ['Content-Type' => "application/xml"],
                            $xmlRoot = 'response');
    }


    public function logs(){
        $payload = "";
        $logs = AccessLog::latest()->get();
        $exclude_this_request = true;

        foreach ($logs as $log){
            if($exclude_this_request){
                $exclude_this_request = false;
                continue;
            }

            if($log->path[0] != "/"){
                $log->path = "/".$log->path;
            }

            $payload .= $log->verb . "\t\t" . $log->path . "\t\t" .
                $log->status . "\t\t" . $log->response_time . "ms\n";

        }

        return response($payload, 200)
            ->header('Content-Type', "text/plain");
    }

    private function validator(Request $request){

        return $this->validate($request, [
            "region"    => "required",
            "region.avgDailyIncomeInUSD" => "required|numeric",
            "region.avgDailyIncomePopulation" => "required|numeric",
            "periodType" => "required|in:days,weeks,months",
            "timeToElapse" => "required|numeric",
            "reportedCases" => "required|numeric",
            "population" => "required|numeric",
            "totalHospitalBeds" => "required|numeric"
        ]);
    }

}
