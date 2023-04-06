<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Facility;
use App\Patient;
use App\Radet;
use App\CaseManager;
use App\PatientList;
use App\Imports\PatientsImport;
use App\Manager;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'All Clients';
        $clients = PatientList::paginate(20);
        $facilities = Facility::all();
        $case_managers = Manager::all();
        // dd($clients);
        return view('clients.index', compact('title','clients','facilities','case_managers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check if a bulk option (csv file upload) was choosen or single option
        //verify and upload in both cases
        list($validator, $msg) = $request->hasFile('bulk-client') ? $this->verifyUploadCSV($request) : $this->verifyUploadSingle($request);

        if ($validator->fails()){
            session()->flash('client_reg_valid_fail', [
                'failed'    => true,
                'msg'       => $msg
            ]);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        return redirect(route('clients'))->with('success', $msg);
    }
    // public function tore(Request $request)
    // {
    //     $rules = [
    //         'name'          => ['required', 'string', 'max:190'],
    //         'clientID'      => ['required', 'digits:7','unique:clients'],
    //         'phone'         => ['required','digits:11'],
    //         'address'       => ['required', 'string'],
    //         'facility'      => 'required',
    //         'case_manager'  => 'required',
    //         'status'        => 'required'
    //     ];

    //     $validator = validator()->make($request->all(), $rules);

    //     if ($validator->fails()){
    //         session()->flash('client_reg_valid_fail', true);
    //         return redirect()->back()->withInput($request->input())->withErrors($validator);
    //     }
    //     $data = [
    //              'name'             =>$request->name, 
    //              'facility_id'      =>$request->facility, 
    //              'clientID'         =>$request->clientID,
    //              'phone'            =>$request->phone,
    //              'opc_phone'        =>isset($request->opc_phone)?$request->opc_phone:'none',
    //              'address'          =>$request->address,
    //              'facility_id'      =>$request->facility,
    //              'case_manager_id'  =>$request->case_manager,
    //              'status'           =>$request->status
    //             ];
    //     Client::create($data);
    //     return redirect(route('clients'))->with('success', 'Client successfully registered');
    // }

     public function findCaseManager(Request $request)
    {
        $case_managers = CaseManager::where('facility_id',$request->id)->get();
        if ($case_managers) {
            return ['status'=>true, 'managers'=>$case_managers];
        }

        return ['status'=>false];
    }

    private function verifyUploadCSV(Request $request)
    {
        $rules = ['bulk-client' => ['required','mimes:csv,txt,xlsx'] ];
        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            //return validator with fail
            $msg = 'csv failed';
            return array($validator, $msg);
        }

        $file = $request->file('bulk-client');
        Excel::import(new PatientsImport, $file);
        // my custom global helper.php function
        // $client_array = csvToArray($file);
        
        // for($i = 0; $i < count($client_array); $i++){
        //     Client::firstOrCreate($client_array[$i]);
        // }

        //return $validator still, but without fail
        $msg = 'All clients fom file successfully registered';
        return array($validator, $msg);
    }

    // upload single client
    private function verifyUploadSingle(Request $request)
    {
         $rules = [
            'name'          => ['required', 'string', 'max:190'],
            'clientID'      => ['required', 'digits:7','unique:clients'],
            'phone'         => ['required','digits:11'],
            'address'       => ['required', 'string'],
            'facility'      => 'required',
            'case_manager'  => 'required',
            'status'        => 'required'
        ];
        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()){
            //return failed validator
            $msg = 'single failed';
            return array($validator, $msg);
        }
        $data = [
                 'name'             =>$request->name, 
                 'facility_id'      =>$request->facility, 
                 'clientID'         =>$request->clientID,
                 'phone'            =>$request->phone,
                 'opc_phone'        =>isset($request->opc_phone)?$request->opc_phone:'none',
                 'address'          =>$request->address,
                 'facility_id'      =>$request->facility,
                 'case_manager_id'  =>$request->case_manager,
                 'status'           =>$request->status
                ];
        Client::create($data);

        //return validator without fail
        $msg = 'Client successfully registered';
        return array($validator, $msg);
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
        $client = Client::find($id);
        $title = 'Edit Client: '.$client->name;
        $facilities = Facility::all();
        return view('clients.edit', compact('title','client','facilities'));
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
        $rules = [
            'name'          => ['required', 'string', 'max:190'],
            'clientID'      => ['required', 'digits:7'],
            'phone'         => ['required','digits:11'],
            'address'       => ['required', 'string'],
            'facility'      => 'required',
            'case_manager'  => 'required',
            'status'        => 'required'
        ];
        $this->validate($request, $rules);
        $client = Client::find($id);
        $data = [
                 'name'             =>$request->name, 
                 'facility_id'      =>$request->facility, 
                 'clientID'         =>$request->clientID,
                 'phone'            =>$request->phone,
                 'opc_phone'        =>isset($request->opc_phone)?$request->opc_phone:'none',
                 'address'          =>$request->address,
                 'facility_id'      =>$request->facility,
                 'case_manager_id'  =>$request->case_manager,
                 'status'           =>$request->status
                ];
        $client->update($data);
        session()->flash('success','Client info Updated');
        return redirect()->route('clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $client = Client::find($request->id);
        $client->delete();
        return true;
    }

    public function assignToCm(Request $request)
    {
        $client = Client::where('clientID',$request->clientID)->first();
        $client->case_manager_id = $request->manager_id;
        $client->save();
        return redirect()->route('view_clients_cm',$request->manager_id)
               ->with('success','Client successfully assigned to case manager');
    }
}
