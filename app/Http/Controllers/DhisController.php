<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DhisImport;
use App\Dhis;
use App\Facility;
use Illuminate\Support\Facades\Http;
use App\DhisDaily;

class DhisController extends Controller
{
    public function index()
    {
    	$title = 'QMAMS - DHIS Area';
    	$datas = Dhis::all();
        $facilities = Facility::all();
    	return view('dhis.index',compact('title','datas','facilities'));
    }

    public function importData(Request $request)
    {
    	$file = $request->file('indicators');
        Excel::import(new DhisImport, $file);
    }

    public function login(Request $request)
    {
        $auth = base64_encode($request->username.':'.$request->password);

        $response = Http::withHeaders([
            'Authorization' => 'Basic '.$auth,
            'Accept'=>'application/json',
        ])->get('https://dhis-sidhasdaily.fhi360.org/api/dataElementOperands',[
            'name'=>'DR Number of viral Load results received Facility, Male, <15 years',
            'value'=>10
        ]);

        return response()->json(['response'=>$response->body()]);
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $indsArr = [];
        foreach ($request->indicator as $key => $value) {
            DhisDaily::create([
                'indicator' => array_key_exists($key, $request->indicator) ? $request->indicator[$key] : 0,
                'facility'  => $request->facility,
                'f_m_l15'   => array_key_exists($key, $request['f_m_l15']) ? $request['f_m_l15'][$key] : 0,
                'f_m_g15'   => array_key_exists($key, $request['f_m_g15']) ? $request['f_m_g15'][$key] : 0,
                'f_f_l15'   => array_key_exists($key, $request['f_f_l15']) ? $request['f_f_l15'][$key] : 0,
                'f_f_g15'   => array_key_exists($key, $request['f_f_g15']) ? $request['f_f_g15'][$key] : 0,
                'c_m_l15'   => array_key_exists($key, $request['c_m_l15']) ? $request['c_m_l15'][$key] : 0,
                'c_m_g15'   => array_key_exists($key, $request['c_m_g15']) ? $request['c_m_g15'][$key] : 0,
                'c_f_l15'   => array_key_exists($key, $request['c_f_l15']) ? $request['c_f_l15'][$key] : 0,
                'c_f_g15'   => array_key_exists($key, $request['c_f_g15']) ? $request['c_f_g15'][$key] : 0,
            ]);
        }



        // DhisDaily::create($indArr);

        return redirect()->back();
    }
}
