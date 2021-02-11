@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>Missed Appointment Alert</h1><br>
	Dear {{ $case_manager }},<br>
	This is to notify you of your missed appointment{{ $data->count() > 1 ? 's with clients' : ' with a client' }} due on the <strong>{{ Carbon\Carbon::parse($date)->format('l jS \of F Y') }}</strong> <br> More info below:
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
<table class="table table-bordered table-striped">
	@foreach($data as $appt)
		<tr>
			<th>Client:</th>
			 <td>{{ $appt->client }}</td>
			</tr>
		<tr>
			<th>Appointment Type:</th>
			<td>{{ ucfirst($appt->appt_type) }}</td>
		</tr>
		<hr>
		################
	@endforeach
</table>
<p><b>Please take all actions necessary to correct {{ $data->count() > 1 ? 'these lapses' : 'this lapse' }}</b></p><br/>
<em style="font-weight: bold; font-size: 15px;">Cheers!</em>
@include('beautymail::templates.widgets.newfeatureEnd')
@stop



