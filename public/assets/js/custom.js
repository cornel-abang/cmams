"use strict";
(function ($) {
	$(document).ready(function() {
		if (page_data.client_reg_valid_fail) {
			$("#add-client-form").modal("show");
		}
    if (page_data.case_manager_reg_valid_fail) {
      $("#add-case-manager-form").modal("show");
    }
    if (page_data.facility_reg_valid_fail) {
      $("#add-facility-form").modal("show");
    }

    if (page_data.report_valid_fail) {
      $("#add-report-form").modal("show");
    }

		$('#entry-table').DataTable( {         
					"ordering": false
				} ); 
	});

  // Ajax Call loading screen
  var loading_area = $('.pcoded-main-container');
  $(document).on({
    ajaxStart: function() { $(loading_area).addClass('loading'); },
    ajaxStop: function() { $(loading_area).removeClass('loading'); }
  });


	$(document).on('click', '#close-msg', function(e){
		e.preventDefault();
		$(this).parent('div').fadeOut(500);
	});

	// Delete facility
	$(document).on('click', '.delete-btn-facility', function(e){
		var handler = $(this);
        var facility_id = handler.attr('id');
        var route = handler.attr('aria-data');
		swal({
             title: "Are you sure?",
              text: "This is an irriversible action",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
            })
            .then((willDelete) => {
              if (willDelete.value === true) {
                $.ajax({
                    type : "POST",
                    url : route,
                    data : {facility_id, _token : page_data.csrf_token},
                    success: function(data){
                    	$(handler).closest('tr').fadeOut(500, function(){
                    		 Swal.fire(
                            'Done!',
                            'Client info deleted',
                            'success'
                          )
                    	});
                    	
                    }
                });
            
              }
        });
        
	});

	// Delete case manager
	$(document).on('click', '.delete-btn-cm', function(e){
		var handler = $(this);
        var manager_id = handler.attr('id');
        var route = handler.attr('aria-data');
		swal({
             title: "Are you sure?",
              text: "This is an irriversible action",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
            })
            .then((willDelete) => {
              if (willDelete.value === true) {
                $.ajax({
                    type : "POST",
                    url : route,
                    data : { id : manager_id, _token : page_data.csrf_token},
                    success: function(data){
                    	$(handler).closest('tr').fadeOut(500, function(){
                    		 Swal.fire(
                            'Done!',
                            'Client info deleted',
                            'success'
                          )
                    	});
                    	
                    }
                });
            
              }
        });
        
	});

  // Delete client
  $(document).on('click', '.delete-btn-client', function(e){
    var handler = $(this);
    var client_id = handler.attr('id');
    swal({
             title: "Are you sure?",
              text: "This is an irriversible action",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
            })
            .then((willDelete) => {
              if (willDelete.value === true) {
                $.ajax({
                    type : "POST",
                    url : page_data.routes.destroy_client,
                    data : { id : client_id, _token : page_data.csrf_token},
                    success: function(data){
                      $(handler).closest('tr').fadeOut(500, function(){
                        Swal.fire(
                            'Done!',
                            'Client info deleted!',
                            'success'
                          )
                      });
                      
                    }
                });
            
              }
        });
        
  });

  // Delete report
  $(document).on('click', '.delete-btn-report', function(e){
    var handler = $(this);
    var report_id = handler.attr('id');
    swal({
             title: "Are you sure?",
              text: "This is an irriversible action",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
            })
            .then((willDelete) => {
              if (willDelete.value === true) {
                $.ajax({
                    type : "POST",
                    url : page_data.routes.destroy_report,
                    data : { id : report_id, _token : page_data.csrf_token},
                    success: function(data){
                      $(handler).closest('tr').fadeOut(500, function(){
                        Swal.fire(
                            'Done!',
                            'Report info deleted!',
                            'success'
                          )
                      }); 
                    }
                });
            
              }
        });
        
  });

  // select case managers based on facility choosen
  $(document).on('change', '.sel_facility', function(){
    var handler = $('.case_managers_select');
    var route = $(handler).attr('title');
    var facility_id = $(this).val();
    $(handler).empty();
    $(handler).attr('disabled',true);
    $('.loading-img').css('display','inline');
      $.ajax({
              type : "GET",
              url : route,
              data : { id : facility_id, _token : page_data.csrf_token},
              success: function(data){
                console.log(data);
                if (data.status) {
                  $(handler).attr('disabled', false);
                  $('.loading-img').css('display','none');
                  $(handler).append('<option value="">Select case manager</option>');
                  data.managers.forEach(function(mg){
                  $(handler).append('<option value="'+mg.id+'">'+mg.name+'</option>');
                  });
                }
              },
              global: false
      });
  });

  // Assign client to case manager frm modal
  $(document).on('change', '#clientIDSearch', function(){
    $('.loading-img').css('display','inline');
    $('.client-info').fadeOut(500);
    $('.no-match').fadeOut(500);
    $('#assgnBtnArea').fadeOut(500);
    var clientID = $(this).val();
    var facility_id = $('#mg_facility').val();
    $.ajax({
              type : "POST",
              url : page_data.routes.search_client,
              data : { clientID, facility_id, _token : page_data.csrf_token},
              success: function(data){
                console.log(data);
                if (data.status) {
                  $('.loading-img').css('display','none');
                  $('.client-info').css('display','inline-block');
                  $('#assgnBtnArea').fadeIn(500);
                  $('#assgnBtnArea').css('display','inline-block');
                  $('#clientName').text(data.client.name);
                  $('#clientPhone').text(data.client.phone);
                  $('#clientOpc').text(data.client.opc_phone);
                  $('#clientAddress').text(data.client.address);
                  $('#clientCm').text(data.case_manager);
                }else{
                  $('.loading-img').css('display','none');
                  $('.no-match').fadeIn(500);
                }
              },
              global: false
      });
  });

  $(document).on('keyup', '#case_manager_name', function(){
    var suggestions_area = $('#suggestions');
    $(suggestions_area).empty();
    var case_mg_name = $(this).val();
    if (case_mg_name !== '') {
      $.ajax({
              type : "GET",
              url : page_data.routes.get_case_manager,
              data : { name : case_mg_name, _token : page_data.csrf_token},
              success: function(res){
                if (res.status) {
                  res.data.forEach(function(sug){
                     $(suggestions_area).append('<tr class="picked" id="'+sug.id+'"><td>'+sug.name+'</td></tr>');
                  });
                }
              },
      });
    }
  });

  $(document).on('click','.picked', function(){
    var case_manager_id = $(this).attr('id');
    var case_manager_name = $(this).text();
    $('#suggestions').empty();
    $('#case_manager_name').val(case_manager_name);
    $('#case_manager_id').val(case_manager_id);
  })

  // Sort reports by day
  $(document).on('change','#report_date', function(){
    var theDay = $(this).val();
    $.ajax({
      type : "GET",
      url : page_data.routes.reports_by_date,
      data : { theDay, _token : page_data.csrf_token},
      success: function(data){
        if (data.status) {
          Swal.fire(
                Object.keys(data.reports).length+' report(s) found on <br>'+(new Date(theDay).toDateString())+'</b>',
                'Loading content now...',
                'success'
              )
          $('#date_sort_form').submit();
        }else{
            Swal.fire(
                'Oops...',
                'Could not find any report on <b>'+(new Date(theDay).toDateString())+'</b>',
                'error' 
              )
        }
      }
    });
  })

  $(document).on('blur','#report_week', function(){
    var week = $(this).val();
    if (week !== '') {
      $.ajax({
        type : "GET",
        url : page_data.routes.reports_by_week,
        data : { week, _token : page_data.csrf_token},
        success: function(data){
          if (data.status) {
            Swal.fire(
                  Object.keys(data.reports).length+' report(s) found <b>'+week+' week(s) back',
                  'Loading content now...',
                  'success'
                )
            $('#week_sort_form').submit();
          }else{
              Swal.fire(
                  'Oops...',
                  'Could not find any report <b>'+week+' week(s) back</b>',
                  'error' 
                )
          }
        }
      });
    }
  })
})( jQuery );