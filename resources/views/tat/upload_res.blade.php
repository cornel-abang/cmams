@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection
                    <div class="row">
                       <div class="col-md-6 edit-form">
                            <h3 class="mt-5 edit-title">Upload Result Copy <br><span class="styled-header">Files</span> </h3>
                            <hr>
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-3 col-sm-12 evidence-area">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Hard Copy</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input{{ $errors->has('hard') ? ' is-invalid' : '' }} inFld" id="inputGroupFile01" name="hard">
                                             @if ($errors->has('hard'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('hard') }}</strong>
                                            </span>
                                            @endif
                                            <span class="custom-file-label" for="inputGroupFile01">Choose file</span>
                                        </div>
                                    <small class="val" id="val-evidence">Allowed Format: xlsx, csv, txt</small>
                                </div>
                                <div class="input-group mb-3 col-sm-12 evidence-area">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Soft Copy</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input{{ $errors->has('soft') ? ' is-invalid' : '' }} inFld" id="inputGroupFile01" name="soft">
                                             @if ($errors->has('soft'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('soft') }}</strong>
                                            </span>
                                            @endif
                                            <span class="custom-file-label" for="inputGroupFile01">Choose file</span>
                                        </div>
                                    <small class="val" id="val-evidence">Allowed Format: xlsx, csv, txt</small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary reg-btn">Import</button>
                                    </div>
                                </div>
                            </form>
                       </div>     
                    </div>

            <style type="text/css">
                form{
                    padding-left: 100px!important;
                    margin-right: 70px;
                }

                .reg-btn{
                    margin-left: 45% !important;
                }

            </style>
@endsection

