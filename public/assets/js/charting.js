"use strict";

	let options = {method:"GET",headers:{'X-CSRF-TOKEN':page_data.csrf_token,'Content-Type':'application/json'}}
	JSC.fetch(page_data.routes.get_refill_data,options)
	.then((response) => response.json())
	.then((res) => renderChart(res))
	.catch((error)=> alert("something went wrong with the Chart - "+error));

	function renderChart(data){
		let series = buildSeries(data);
		plotChart(series);
	}

	function plotChart(series)
	{
		JSC.Chart("performance-chart", {
			type: 'spline',
			legend_template: "%average %icon %name",
			title_label_text:'This week\'s performance chart',
			xAxis_label_text: 'Weekday',
			yAxis_label_text: 'Performance percentage (%)',
			palete: ['#eeeeee'],
			defaultPoint:{
				marker_visible: true,
				size:7,
			},
			defaultPoint_marker:{
				size:10,
				outline_color: 'white'
			},
		  	series: series
		});
	}

	function buildSeries(data){
		const days = ["Monday","Tuesday","Wednesday","Thursday","Friday"];
		let refill_series = [];
		let viral_load_series = [];
		let att_series = [];
		let ict_series = [];
		let tpt_series = [];
		let tracking_series = [];
		// Create attendance series
		for( let i=0; i<data['attendance'].length; i++){
			att_series.push({ x:days[i], y:data['attendance'][i] });
		}
		// Create refill series
		for( let i=0; i<data['refill'].length; i++){
			refill_series.push({ x:days[i], y:data['refill'][i] });
		}
		// Create viral load series
		for( let i=0; i<data['viral_load'].length; i++){
			viral_load_series.push({ x:days[i], y:data['viral_load'][i] });
		}
		// Create ict series
		for( let i=0; i<data['ict'].length; i++){
			ict_series.push({ x:days[i], y:data['ict'][i] });
		}
		// Create tpt series
		for( let i=0; i<data['tpt'].length; i++){
			tpt_series.push({ x:days[i], y:data['tpt'][i] });
		}
		// Create tracking series
		for( let i=0; i<data['tracking'].length; i++){
			tracking_series.push({ x:days[i], y:data['tracking'][i] });
		}
		return [
			{name: 'Attendance', points: att_series},
			{name: 'Refill', points: refill_series},
			{name: 'Viral Load', points: viral_load_series},
			{name: 'ICT', points: ict_series},
			{name: 'TPT', points: tpt_series},
			{name: 'Tracking', points: tracking_series}
		]
	}
	