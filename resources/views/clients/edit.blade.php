@extends('layouts.dashboard')

@section('content')
                    <div class="row">
                       <div class="col-md-7 edit-form">
                        <h3 class="mt-5 edit-title">Edit Client <br><span class="styled-header">{{$client->name}}</span> </h3>
                            <hr>
                            <form action="" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Client Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$client->name}}" required>
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Client ID</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('clientID') ? ' is-invalid' : '' }}" name="clientID" value="{{$client->clientID}}">
                                        @if ($errors->has('clientID'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('clientID') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{$client->phone}}">
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Phone Number OPC (Optional)</label>
                                    <div class="col-sm-9">
                                        <input type="phone" class="form-control{{ $errors->has('opc_phone') ? ' is-invalid' : '' }}" name="opc_phone" value="{{ $client->opc_phone }}">
                                        @if ($errors->has('opc_phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('opc_phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Residential Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{$client->address}}">
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <div class="input-group mb-3 col-sm-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Facility</label>
                                        </div>
                                        <select class="custom-select{{ $errors->has('facility') ? ' is-invalid' : '' }} sel_facility" name="facility" id="inputGroupSelect01">
                                            @foreach($facilities as $fac)
                                            <option value="{{$fac->id}}" {!! $client->facility_id === $fac->id ? 'selected':''!!}>
                                                {{$fac->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('facility'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('facility') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-sm-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Assign Case Manager</label>
                                        </div>
                                        <select class="custom-select{{ $errors->has('case_manager') ? ' is-invalid' : '' }} case_managers_select" name="case_manager" selected="{{old('case_manager')}}" id="inputGroupSelect01" required title="{{route('find_case_managers')}}">
                                            <option value="{{$client->caseManager->id}}" selected>{{$client->caseManager->name}}</option>
                                        </select><img src="{{asset('assets/images/loading.gif')}}" class="loading-img">
                                        @if ($errors->has('case_manager'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('case_manager') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-group mb-3 col-sm-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Status</label>
                                        </div>
                                        <select class="custom-select{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" selected="{{old('status')}}" id="inputGroupSelect01">
                                            <option value="Active" {!! $client->status === 'Active' ? 'selected':''!!}>Active</option>
                                            <option value="Dead" {!! $client->status === 'Dead' ? 'selected':''!!}>Dead</option>
                                            <option value="Transferred Out" {!! $client->status === 'Transferred Out'?'selected':''!!}>Transferred Out</option>
                                            <option value="Lost to Follow Up" {!! $client->status === 'Lost to Follow Up' ? 'selected':''!!}>Lost to Follow Up</option>
                                            <option value="Stop Treatment" {!! $client->status === 'Stop Treatment' ? 'selected':''!!}>Stop Treatment</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary btn-edit-client">Save</button>
                                    </div>
                                </div>
                            </form>
                       </div>         
                  </div>
@endsection

