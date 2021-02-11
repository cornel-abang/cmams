@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>VL Results TAT Reminder - <strong>({{ $days }}-day{{ $days===1?'':'s' }})</strong></h1>
	This is a reminder that the following client{{ $data->count()>1?'s':'' }}, whose information appear{{ $days===1?'s':'' }} below, {{ $data->count()>1?'have':'has' }} Viral Load Result{{ $data->count()>1?'s':'' }} due in <strong>{{ $days }} Day{{ $days===1?'':'s' }}</strong> <strong>({{ \Carbon\Carbon::parse($due_date)->format('l jS \of F Y') }})</strong>.<br>Information enumerated below:
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
<table class="table table-bordered table-striped">
    	@foreach($data as $vlc)
	    	<tr>
				<th>Client Hospital Number:</th>
				<td>{{ $vlc->client }}</td>
			</tr>
			<tr>
				<th>Client Facility:</th>
				<td>{{ $vlc->facility }}</td>
			</tr>
			<tr>
				<th>Case Manager Involved:</th>
				<td>{{ $vlc->case_manager }}</td>
			</tr>
			<hr>
		################
    	@endforeach
</table>
<p><b>Please keep in mind and take necessary action before the due date.</b></p>
@include('beautymail::templates.widgets.newfeatureEnd')
@stop