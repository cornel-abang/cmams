<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Tracking;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trackings = Tracking::all();
        $title = 'All tracking reports';
        return view('tracking.index', compact('title','trackings'));
    }

    public function searchClient(Request $request)
    {
        $res = false;
        $case_manager = false;
        $client = Client::where('clientID',$request->clientID)->first();
        if ($client) {
            $res = true;
            $case_manager = $client->caseManager->name;
        }
        return ['status'=>$res, 'client'=>$client, 'case_manager'=>$case_manager];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add tracking report';
        return view('tracking.add',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'clientID'       => ['required'],
            'method'         => 'required',
            'evidence'       => ['required','mimes:mpga,wav,jpeg,png,jpg,ogg','max:5120']
        ];

        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()){
            return response()->withErrors($validator);
            // return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
        if ($file = $request->file('evidence')) {
            $name = $file->getClientOriginalName();
            $storagePath = public_path('/assets/evidences/');
            if ($file->move($storagePath, $name)) {
                $client = Client::find($request->client_id);
                $cm_id = $client->caseManager->id;
                $data = [
                            'client_id'         => $request->client_id,
                            'case_manager_id'   => $cm_id,
                            'method'            => $request->method,
                            'evidence'          => $name
                        ];
                Tracking::create($data);
                return response(true);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
