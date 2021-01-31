@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>Due Viral Load Results - <strong>(2-days)</strong></h1>
	This is a reminder that the following clients, whose information appear below, have Viral Load Results due in <strong>2 Days</strong> <strong>({{ \Carbon\Carbon::parse($due_date)->format('l jS \of F Y') }})</strong>.<br> They are enumerated below:
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