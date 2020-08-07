@extends('layouts.dashboard')

@section('content')
                    <div class="row">
                       <div class="col-md-7 edit-form">
                        <h3 class="mt-5 edit-title">Edit tracking report by <br>
                            <span class="styled-header">{{$tracking->caseManager->name}}</span> </h3>
                            <hr>
                            <form action="" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Case Manager</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="{{$tracking->caseManager->name}}" disabled>
                                        <input type="hidden" name="case_manager_id" value="{{$tracking->caseManager->id}}">
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Client ID</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="{{$tracking->client->clientID}}" disabled>
                                        <input type="hidden" name="client_id" value="{{$tracking->client->id}}">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <div class="input-group mb-3 col-sm-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Method</label>
                                        </div>
                                        <select class="custom-select{{ $errors->has('method') ? ' is-invalid' : '' }}" 
                                            name="method" id="inputGroupSelect01">
                                            <option value="phone" {!! $tracking->method === 'phone' ? 'selected':''!!}>
                                                Phone call
                                            </option>
                                            <option value="visit" {!! $tracking->method === 'visit' ? 'selected':''!!}>
                                                Home visit
                                            </option>
                                        </select>
                                        @if ($errors->has('method'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('method') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="custom-file">
                                            <input type="file" class="custom-file-input{{ $errors->has('evidence') ? ' is-invalid' : '' }} inFld" id="inputGroupFile01" name="evidence">
                                             @if ($errors->has('evidence'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('evidence') }}</strong>
                                            </span>
                                            @endif
                                            <span class="custom-file-label" for="inputGroupFile01">Choose file</span>
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

