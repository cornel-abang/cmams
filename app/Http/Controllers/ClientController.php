<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Facility;
use App\CaseManager;

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
        $clients = Client::all();
        $facilities = Facility::all();
        $case_managers = CaseManager::all();
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
            session()->flash('client_reg_valid_fail', true);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
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
        return redirect(route('clients'))->with('success', 'Client successfully registered');
    }

     public function findCaseManager(Request $request)
    {
        $case_managers = CaseManager::where('facility_id',$request->id)->get();
        if ($case_managers) {
            return ['status'=>true, 'managers'=>$case_managers];
        }

        return ['status'=>false];
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
