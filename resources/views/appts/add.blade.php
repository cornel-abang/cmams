@extends('layouts.dashboard')
@section('content')
{{-- @section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection --}}
                    <div class="row">
                       <div class="col-md-7 edit-form">
                        <h3 class="mt-5 edit-title">Upload new <br><span class="styled-header">Appointments</span> </h3>
                            <hr>
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-3 col-sm-9 evidence-area">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Upload CSV</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input{{ $errors->has('appt_file') ? ' is-invalid' : '' }} inFld" id="inputGroupFile01" name="appt_file">
                                            <span class="custom-file-label" for="inputGroupFile01">Choose file</span>
                                        </div>
                                        @if ($errors->has('appt_file'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('appt_file') }}</strong>
                                            </span>
                                        @endif
                                    <small class="val" id="val-evidence">Please upload a correct file format: .csv or .txt only</small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary reg-btn">Upload</button>
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

