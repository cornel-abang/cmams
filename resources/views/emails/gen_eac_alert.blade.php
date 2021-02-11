@extends('beautymail::templates.widgets')

@section('content')
@include('beautymail::templates.widgets.articleStart', ['color' => 'black'])
<h1>EAC Clients Alert</h1><br>
	Dear Sir/Madam,<br>
	This is to bring to your notice that the following clients are to be started on <strong>Enhanced Adhrence Counselling (EAC)</strong>. This is because their most recent Viral Load results received, indicated that they're unsuppressed.<br/> They are listed below:
@include('beautymail::templates.widgets.articleEnd')

@include('beautymail::templates.widgets.newfeatureStart', ['color'=>'#ffbf00'])
<table class="table table-bordered table-striped">
	{{-- <thead>
		<tr>
			<th>Client</th>
			<th>Current VL</th>
			<th>Result Return Date</th>
			<td>First EAC Session</td>
			<td>Second EAC Session</td>
			<td>Next Sample Collection</td>
			<td>Case Manager</td>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $appt)
		<tr>
			<td>{{ $appt->client }}</td>
			<td>{{ $appt->current_viral_load }}</td>
			<td>{{ Carbon\Carbon::parse($appt->last_vl_result)->format('l jS \of F Y') }}</td>
			<td>{{ Carbon\Carbon::parse($appt->last_vl_result)->addMonths(1)->format('l jS \of F Y') }}</td>
			<td>{{ Carbon\Carbon::parse($appt->last_vl_result)->addMonths(2)->format('l jS \of F Y') }}</td>
			<td>{{ Carbon\Carbon::parse($appt->last_vl_result)->addMonths(3)->format('l jS \of F Y') }}</td>
			<td>{{ $appt->case_manager }}</td>
		</tr>
		@endforeach
	</tbody> --}}
	@foreach($data as $appt)
		<tr>
			<th>Client:</th>
			 <td>{{ $appt->client }}</td>
			</tr>
		<tr>
			<th>Current Viral Load:</th>
			<td>{{ $appt->current_viral_load }}</td>
		</tr>
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
		<tr>
			<th>Case Manager:</th>
			 <td>{{ $appt->case_manager }}</td>
			</tr>
		<tr>
		<hr>
		################
	@endforeach
</table>
<p><b>Please endeavor to carry out all necessary actions to bring them in for their counselling sessions and sample collection on respective due dates.</b></p><br/>
<em style="font-weight: bold; font-size: 15px;">Have a wonderful day.</em>
@include('beautymail::templates.widgets.newfeatureEnd')
@stop