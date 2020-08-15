@extends('layouts.dashboard')

@section('content')
                    <div class="row">
                       <div class="col-md-7 edit-form">
                        <h3 class="mt-5 edit-title">Edit Case Manager <br><span class="styled-header">{{$manager->name}}</span> </h3>
                            <hr>
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Full Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$manager->name}}">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Email Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$manager->email}}">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group mb-3 col-sm-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Facility</label>
                                        </div>
                                        <select class="custom-select{{ $errors->has('facility') ? ' is-invalid' : '' }}" name="facility" id="inputGroupSelect01">
                                            @foreach($facilities as $fac)
                                            <option value="{{$fac->id}}" {!! $manager->facility_id === $fac->id ? 'selected':''!!}>
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
                                            <label class="input-group-text">Profile Photo</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input{{ $errors->has('profile_photo') ? ' is-invalid' : '' }}" id="inputGroupFile01" name="profile_photo">
                                             @if ($errors->has('profile_photo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('profile_photo') }}</strong>
                                            </span>
                                            @endif
                                            <span class="custom-file-label" for="inputGroupFile01">Choose file</span>
                                        </div>
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

