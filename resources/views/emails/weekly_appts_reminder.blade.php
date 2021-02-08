@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>Weekly Pre-appointment Notice</h1><br>
	Dear {{ $case_manager }},<br>
	This is a weekly reminder, detailing all your appointments due for this week, beginning today: <strong>{{ Carbon\Carbon::today()->format('l jS \of F Y') }}</strong> <br> They are enumerated below:
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
<table class="table table-bordered table-striped">
	@foreach($data as $appt)
		<tr>
			<th>Client:</th>
			 <td>{{ $appt->client_hospital_num }}</td>
			</tr>
			<hr>
		<tr>
			<th>Appointment Type:</th>
			<td>{{ ucfirst($appt->type) }}</td>
		</tr>
		<hr>
		<tr>
			<th>Appointment Date:</th>
			<td>{{ Carbon\Carbon::parse($appt->appt_date)->format('l jS \of F Y') }}</td>
		</tr>
		<hr>
		################
	@endforeach
</table>
<p><b>Please endeavor to meet all your appointments as they will be checked on CMAMS (Case Manager Analysis & Monitoring System) when reporting on due date.</b></p><br/>
<em style="font-weight: bold; font-size: 15px;">Have a wonderful week ahead.</em>
@include('beautymail::templates.widgets.newfeatureEnd')
@stop