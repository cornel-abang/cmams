@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>EAC Clients Alert</h1><br>
	Dear {{ $case_manager }},<br>
	This is to bring to your notice that the following of your clients are to be started on<strong>Enhanced Adhrence Counselling (EAC)</strong>. This is because their most recent Viral Load results received, indicated that they're unsuppressed.<br> They are enumerated below:
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
<table class="table table-bordered table-striped">
	@foreach($data as $appt)
		<tr>
			<th>Client:</th>
			 <td>{{ $appt->client }}</td>
			</tr>
			<hr>
		<tr>
			<th>Current Viral Load:</th>
			<td>{{ $appt->current_viral_load }}</td>
		</tr>
		<hr>
		<tr>
			<th>Result Return Date:</th>
			<td>{{ Carbon\Carbon::parse($appt->last_vl_result)->format('l jS \of F Y') }}</td>
		</tr>
		<tr>
			<th>First EAC Session:</th>
			<td>{{ Carbon\Carbon::parse($appt->last_vl_result)->addMonths(1)->format('l jS \of F Y') }}</td>
		</tr>
		<tr>
			<th>Second EAC Session:</th>
			<td>{{ Carbon\Carbon::parse($appt->last_vl_result)->addMonths(2)->format('l jS \of F Y') }}</td>
		</tr>
		<tr>
			<th>Next Sample Collection Date:</th>
			<td>{{ Carbon\Carbon::parse($appt->last_vl_result)->addMonths(3)->format('l jS \of F Y') }}</td>
		</tr>
		<hr>
		################
	@endforeach
</table>
<p><b>Please endeavor to reach out to the client(s) and bring them in for their counselling sessions and sample collection on respective due dates.</b></p><br/>
<em style="font-weight: bold; font-size: 15px;">Have a wonderful day.</em>
@include('beautymail::templates.widgets.newfeatureEnd')
@stop