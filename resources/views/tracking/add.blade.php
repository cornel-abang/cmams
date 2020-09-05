@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection
                    <div class="row">
                       <div class="col-md-7 edit-form">
                        <h3 class="mt-5 edit-title">Add new <br><span class="styled-header">Tracking Report</span> </h3>
                            <hr>
                            <form action="" method="post" id="tracking_report_form" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Client ID</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control{{ $errors->has('clientID') ? ' is-invalid' : '' }} inFld" 
                                            name="clientID" value="{{old('clientID')}}" id="clientID_tracking" required>
                                            <img src="{{asset('assets/images/loading.gif')}}" class="loading-img" alt="loader">
                                        <small class="client-info-on-tracking user_info la la-user" id="client_info">
                                           
                                        </small>
                                        @if ($errors->has('clientID'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('clientID') }}</strong>
                                            </span>
                                        @endif
                                        {{-- Area to hold the fetched client_id --}}
                                        <input type="hidden" name="client_id" value="{{old('client_id')}}" id="client_id" class="inFld"> 
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="input-group mb-3 col-sm-9">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Tracking Method</label>
                                        </div>
                                        <select class="custom-select{{ $errors->has('method') ? ' is-invalid' : '' }} inFld" name="method" id="inputGroupSelect01">
                                            <option value="">--Select method--</option>
                                            <option value="visit">Home visit</option>
                                            <option value="phone">Phone call</option>
                                        </select>
                                        <small class="val" id="val-method">Please select a tracking method</small>
                                        @if ($errors->has('method'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('method') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group mb-3 col-sm-9 evidence-area">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Evidence</label>
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
                                    <small class="val" id="val-evidence">Please choose a correct file format:jpeg, jpg, png, wav, mp3</small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        {{-- Loading button --}}
                                        <button class="btn  btn-primary m-2 load-btn" type="button" disabled>
                                            <span class="spinner-border spinner-border-sm" role="status"></span>
                                            Saving...
                                        </button>
                                        {{-- Loading btn ends --}}
                                        <button type="submit" class="btn  btn-primary reg-btn">Save</button>
                                    </div>
                                </div>
                            </form>
                       </div>         
                  </div>
            <style type="text/css">
                form{
                    padding-left: 150px!important;
                }

                form .evidence-area{
                    padding-left: 0!important;
                    padding-right: 0 !important;
                }

                .load-btn{
                    margin-left: 30% !important;
                    display: none;
                }

                .reg-btn{
                    margin-left: 35% !important;
                }

               /* .add-more{
                    margin-left: -38% !important;
                    font-weight: bold;
                }

                input[placeholder], select, input[type='file']{
                    font-size: 10px !important;
                }*/
            </style>
@endsection

