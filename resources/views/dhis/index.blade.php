<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QMAMS - Dhis2 Interface</title>

    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">

    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('assets/dhis/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

    {{-- Bootstrap --}}
    <link rel='stylesheet' href='{{ asset('assets/dhis/bootstrap/dist/css/bootstrap.min.css') }}' type='text/css' />
    <link rel="stylesheet" href="{{asset('assets/js/selectize.js-master/dist/css/selectize.bootstrap3.css')}}"/>

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('assets/dhis/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datatables.css')}}">
    <link href="{{ asset('assets/font-awesome-5/css/all.min.css')}}" rel="stylesheet">
    <script type='text/javascript'>
        var page_data = {!! pageJsonData() !!};
        let errors = [];
        const first = [];
    </script>
</head>
<body style="background: #f8fafc;">

    <div class="main">

        <div class="container">
            <div class="logo-area">
                <div class="logos">
                    <img src="{{ asset('assets/dhis/images/dhis2.png') }}" width="200" height="170" class="img-fluid dhis">
                    <img src="{{ asset('assets/images/qmams-dhis.png') }}" alt="" class="img-fluid q-mams" >
                </div>
                <br>
                <div class="info-txt">
                    <p>
                        This suite serves as a data collection interface for the Dhis software. It is by no means part of the Dhis software per se.
                        Follow the below instructions to ease your data entry process to reduce the margin for error and also save enormous amount of time.<br>
                        {{-- <ul class="instructions">
                            <li><em>Click only on the Data Elements you wish to input data for</em></li><br>
                            <li><em>Enter data on the modal that pops up for each Data Element</em></li><br>
                            <li><em>Do not bother entering zero for any Data Element</em></li><br>
                            <li><em>Hover over a Data Element to see more info about it</em></li>
                        </ul> --}}
                        {{-- <form enctype="multipart/form-data" action="{{ route('indicators') }}" method="POST">
                            @csrf
                            <input type="file" name="indicators">
                            <input type="submit" value="import">
                        </form> --}}
                    </p>
                </div>
            </div>
            <form method="POST" id="signup-form" class="signup-form" enctype="multipart/form-data">
                @csrf
                <div class="date-field row">
                    <div class="col-md-6">
                        <small>Facility:</small>
                        <select name="sel-facility" class="form-control col-md-6" id="facility-select">
                            <option value="">Select facility</option>
                            @foreach($facilities as $facility)
                                <option value="{{ $facility->name }}">{{ $facility->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <small>Report Date:</small>
                        <input type="date" name="" class="form-control col-md-6">
                    </div>
                </div>
                <h3 >
                    First 95
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#first">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for First 95">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'first')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    Index Testing 
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#index_testing">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for Index Testing">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'index_testing')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    Second 95
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#second">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for Seond 95">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'second')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    Third 95
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#third">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for Third 95">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'third')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    TB/HIV
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#tbhiv">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for TB">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'tb_hiv')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    PrEP & GBV
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#p_g">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for PrEP & GBV">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'prep_gbv')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    Cervical Cancer
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#c_cancer">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for Cervical Cancer">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'cervicsl_cancer')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    HIVST
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#hivst">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for HIVST">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'hivst')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    HTS Recent
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#hts_recent">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for HTS Recent">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'hts_recent')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    HIV Self Testing
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#self">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for HIV Self Testing">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                @foreach($datas as $data)
                                    @if($data->indicator  !== '')
                                        @if($data->tag === 'hiv_self_testing')
                                            <span class="badge-pill badge-secondary">{{ $data->sn }}</span><a href="" class="btn btn-lg btn-primary btn_{{ $data->sn }}" data-toggle="modal" data-target="#indicator{{ $data->id }}">
                                                <span data-toggle="tooltip" title="{{ $data->indicator }}">
                                                    {{ \Illuminate\Support\Str::limit($data->indicator, 200, $end='...') }}
                                                </span>
                                            </a><br>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>

    </div>
    <form method="POST" id="daily_rep_frm">
    {{-- <input type="hidden" name="hidden-facility" class="hidden-facility"> --}}
    @foreach($datas as $data)
        @if($data->indicator !== '')
            <div class="modal fade" id="indicator{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <p style="color: #007bff; font-weight: bold;">
                            @if($data->tag === 'first')
                                First 95%
                            @elseif($data->tag === 'second')
                                Second 95%
                            @elseif($data->tag === 'third')
                                Third 95%
                            @elseif($data->tag === 'index_testing')
                                Index Testing
                            @elseif($data->tag === 'tb_hiv')
                                TB/HIV
                            @elseif($data->tag === 'prep_gbv')
                                PrEP & GBV
                            @elseif($data->tag === 'cervicsl_cancer')
                                Cervical Cancer
                            @elseif($data->tag === 'hivst')
                                HIVST
                            @elseif($data->tag === 'hts_recent')
                                HTS Recent
                            @elseif($data->tag === 'hiv_self_testing')
                                HIV Self Testing
                            @endif
                        </p>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div style="background: #f8fafc; font-size: 16px; text-align: center; padding: 7px;">
                        <p>{{ $data->indicator }}</p>
                    </div>
                    {{-- <form method="POST" id="daily_rep_frm"> --}}
                        @csrf
                        @php $i=0 @endphp

                        <input type="hidden" name="indicator[]" value="{{ $data->sn }}">
                      <h2>Facility</h2><br>
                      <div class="form-group row">

                        @if($data->special !== 'females')

                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Male</label>
                        <div class="col-sm-4">
                          <label style="font-size: 12px; font-weight: bold; padding: 5px">< 15yrs</label>
                          <input type="number" name="f_m_l15[]" class="form-control facility indicator prev_in indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '22ix'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}} demo_m_less_15 {{ $data->sn == '29'?'i_28_29':'' }}"  data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" data-tag="{{ $data->tag }}" data-pointer=".m_less_15" data-from=".facility" data-indicator="#ind{{ $data->sn }}" data-demo="demo_m_less_15" value="0">
                          <span class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </span>

                          @if($data->special !== 'less_than_15')
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" name="f_m_g15[]" class="form-control facility indicator prev_in indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '22ix'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}} demo_m_great_15" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" data-tag="{{ $data->tag }}" data-pointer=".m_great_15" data-from=".facility" data-indicator="#ind{{ $data->sn }}" data-demo="demo_m_great_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </div>
                          @endif

                        </div>

                        @endif

                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Female</label>
                        <div class="col-sm-4">
                          <label style="font-size: 12px; font-weight: bold; padding: 5px"> < 15yrs</label>
                          <input type="number" name="f_f_l15[]" class="form-control facility indicator prev_in indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '22ix'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}} demo_f_less_15" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" data-tag="{{ $data->tag }}" data-pointer=".f_less_15" data-from=".facility" data-indicator="#ind{{ $data->sn }}" data-demo="demo_f_less_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </div>

                          @if($data->special !== 'less_than_15')
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" name="f_f_g15[]" class="form-control facility indicator prev_in indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '22ix'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}} demo_f_great_15" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" data-tag="{{ $data->tag }}" data-pointer=".f_great_15" data-from=".facility" data-indicator="#ind{{ $data->sn }}" data-demo="demo_f_great_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </div>
                          @endif
                        </div>
                      </div>
                      @if($data->sn != 1)
                      <h2>Community</h2><br>
                      <div class="form-group row">

                        @if($data->special !== 'females')
                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Male</label>
                        <div class="col-sm-4">
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> < 15yrs</label>
                          <input type="number" name="c_m_l15[]" class="form-control community indicator prev_in indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '22ix'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}} demo_m_less_15" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" data-tag="{{ $data->tag }}" data-pointer=".m_less_15" data-from=".community" data-indicator="#ind{{ $data->sn }}" data-demo="demo_m_less_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </div>

                          @if($data->special !== 'less_than_15')
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" name="c_m_g15[]" class="form-control community indicator prev_in indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '22ix'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}} demo_m_great_15" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" data-tag="{{ $data->tag }}" data-pointer=".m_great_15" data-from=".community" data-indicator="#ind{{ $data->sn }}" data-demo="demo_m_great_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </div>
                          @endif

                        </div>
                        @endif

                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Female</label>
                        <div class="col-sm-4">
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> < 15yrs</label>
                          <input type="number" name="c_f_l15[]" class="form-control community indicator prev_in indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '22ix'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}} demo_f_less_15" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" data-tag="{{ $data->tag }}" data-pointer=".f_less_15" data-from=".community" data-indicator="#ind{{ $data->sn }}" data-demo="demo_f_less_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </div>

                          @if($data->special !== 'less_than_15')
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" name="c_f_g15[]" class="form-control community indicator prev_in indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '22ix'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}} demo_f_great_15" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" data-tag="{{ $data->tag }}" data-pointer=".f_great_15" data-from=".community" data-indicator="#ind{{ $data->sn }}" data-demo="demo_f_great_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </div>
                          @endif

                        </div>
                      </div>

                      {{-- <h2>Home Delivery</h2><br>
                      <div class="form-group row">
                        @if($data->special !== 'females')
                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Male</label>
                        <div class="col-sm-4">

                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> < 15yrs</label>
                          <input type="number" class="form-control indicator indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '24'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}}" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" id="inputPassword" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </div>

                          @if($data->special !== 'less_than_15')
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" class="form-control indicator indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '24'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}}" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" id="inputPassword" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 40, $end='...') }} 
                            </p>
                          </div>
                          @endif

                        </div>
                        @endif

                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Female</label>
                        <div class="col-sm-4">
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> < 15yrs</label>
                          <input type="number" class="form-control indicator indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '24'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}}" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 45, $end='...') }} 
                            </p>
                          </div>

                          @if($data->special !== 'less_than_15')
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" class="form-control indicator indicator_{{ $data->sn }} tag_{{ $data->sn }} {{ $data->sn == '24'?'elem_21_22v':''}} {{ $data->sn == '67'?'elem_67_68':''}} {{ $data->sn == '68'?'elem_67_68':''}}" data-sn="{{ $data->sn }}" data-greater="{{ $data->not_greater_than??0 }}" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="{{ $data->validation_text }}">
                                {{ \Illuminate\Support\Str::limit($data->validation_text, 45, $end='...') }} 
                            </p>
                          </div>
                          @endif

                        </div>
                      </div> --}}
                      @endif
                    {{-- </form> --}}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Save</button>
                    {{-- <button type="button" class="btn btn-primary">Save</button> --}}
                  </div>
                </div>
              </div>
            </div>
        @endif
    @endforeach

    {{-- First 95 preview modal --}}
    @include('layouts.preview.first')
    @include('layouts.preview.second')
    @include('layouts.preview.third')
    @include('layouts.preview.tb_hiv')
    @include('layouts.preview.prep_gbv')
    @include('layouts.preview.cervical_cancer')
    @include('layouts.preview.hivst')
    @include('layouts.preview.hts_recent')
    @include('layouts.preview.index_testing')
    @include('layouts.preview.self_testing')

    <style type="text/css">
        form h3{
            font-size: 13px;
            font-weight: bold;
        }

        .steps ul li a{
            height: 50px;
        }

        .errorMsg{
          color: red !important;
          font-size: 11px;
        }

        .errorHide{
            display: none;
        }

        .errorShow{
            display: inline-block;
        }

        .errorSig{
            border: 1px solid red;
        }

        .shutDown{
            display: none !important;
        }

        .badge-secondary, .badge-success{
            font-weight: bold;
        }

        .scrollable-content.qst-txt{
            height: 300px;
        }

        .scrollable-content.qst-txt a.btn{
            margin: 0!important;
        }

        .preview-btn{
            color: white!important;
            font-weight: bold;
            margin-bottom: 10px;
            padding: 10px;
        }

        .preview-btn i span{
            font-weight: bold !important;
        }

        fieldset{
            margin-top: -40px !important;
        }

        .preview-table tr td:first-child{
            width: 400px;
        }

        .date-field{
            margin-top: 20px;
        }

        .date-field small{
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>

    <!-- JS -->
    <script src="{{ asset('assets/dhis/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/dhis/vendor/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/dhis/vendor/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/dhis/vendor/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/dhis/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script src="{{asset('assets/js/selectize.js-master/dist/js/standalone/selectize.min.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src='{{ asset('assets/dhis/bootstrap/dist/js/bootstrap.min.js') }}'></script>
</body>
</html>