@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>Weekly client appointments reminder</h1>
	This is a reminder of your appointments with clients that are due this week.<br> They are enumerated below:
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
<table class="table table-bordered table-striped">
	@foreach($data['appts'] as $appt)
		<tr>
			<th>Client Name:</th>
			 <td>{{ $appt->client->name }}</td>
			</tr>
			<hr>
		<tr>
			<th>Appointment Type:</th>
			<td>{{ $appt->type }}</td>
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
<p><b>Please endeavor to meet all your appointments as they will be checked on CMAMS when reporting on due date.</b></p>
@include('beautymail::templates.widgets.newfeatureEnd')
@stop



