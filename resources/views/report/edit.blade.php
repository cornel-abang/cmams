@extends('layouts.dashboard')

@section('content')
                    <div class="row">
                       <div class="col-md-7 edit-form">
                        <h3 class="mt-5 edit-title">Edit Report by <br><span class="styled-header">{{$report->caseManager->name}}</span> </h3>
                            <hr>
                            <form action="" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Case Manager Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('case_manager_name') ? ' is-invalid' : '' }}" name="case_manager_name" value="{{$report->caseManager->name}}">
                                        @if ($errors->has('case_manager_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('case_manager_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                 <input type="hidden" name="case_manager_id" id="case_manager_id" value="{{$report->caseManager->id}}">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Refill</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('refill_deno') ? ' is-invalid' : '' }}" name="refill_deno" value="{{$report->refill_deno}}">
                                        <small class="edit-report-small">No. due for refill</small>
                                        @if ($errors->has('refill_deno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('refill_deno') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('refill_numo') ? ' is-invalid' : '' }}" name="refill_numo" value="{{$report->refill_numo}}">
                                        <small class="edit-report-small">No. refilled</small>
                                        @if ($errors->has('refill_numo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('refill_numo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Viral Load</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('viral_load_deno') ? ' is-invalid' : '' }}" name="viral_load_deno" value="{{$report->viral_load_deno}}">
                                        <small class="edit-report-small">No. due for sample collection</small>
                                        @if ($errors->has('viral_load_deno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('viral_load_deno') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('viral_load_numo') ? ' is-invalid' : '' }}" name="viral_load_numo" value="{{$report->viral_load_numo}}">
                                        <small class="edit-report-small">No. collected</small>
                                        @if ($errors->has('viral_load_numo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('viral_load_numo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">ICT</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('ict_deno') ? ' is-invalid' : '' }}" name="ict_deno" value="{{$report->ict_deno}}">
                                        <small class="edit-report-small">No. offered</small>
                                        @if ($errors->has('ict_deno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ict_deno') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('ict_numo') ? ' is-invalid' : '' }}" name="ict_numo" value="{{$report->ict_numo}}">
                                        <small class="edit-report-small">No. elicited</small>
                                        @if ($errors->has('ict_numo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ict_numo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">TPT</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('tpt_deno') ? ' is-invalid' : '' }}" name="tpt_deno" value="{{$report->tpt_deno}}">
                                        <small class="edit-report-small">No. eligible</small>
                                        @if ($errors->has('tpt_deno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tpt_deno') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('tpt_numo') ? ' is-invalid' : '' }}" name="tpt_numo" value="{{$report->tpt_numo}}">
                                        <small class="edit-report-small">No. offered</small>
                                        @if ($errors->has('tpt_numo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tpt_numo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Comment</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" value="{{old('comment')}}">{{$report->comment}}</textarea>
                                        @if ($errors->has('comment'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('comment') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="custom-control custom-checkbox text-left mb-4 mt-2 featured">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="tag" 
                                    {!! $report->tag === 'on'?'checked':'' !!}>
                                    <label class="custom-control-label" for="customCheck1">Mark as featured?</label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary reg-btn">Save</button>
                                    </div>
                                </div>
                            </form>
                       </div>         
                  </div>
@endsection

