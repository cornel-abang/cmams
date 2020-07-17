@extends('layouts.dashboard')

@section('content')
                    <div class="row">
                       <div class="col-md-7 edit-form">
                        <h3 class="mt-5 modal-title">Edit <span class="styled-header">{{$facility->name}}</span> facility</h3>
                            <hr>
                            <form action="" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Facilty Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$facility->name}}">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Name of Backstop</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('backstop') ? ' is-invalid' : '' }}" name="backstop" value="{{$facility->backstop}}">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('backstop') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary reg-btn">Save changes</button>
                                    </div>
                                </div>
                            </form>
                       </div>         
                  </div>
@endsection

