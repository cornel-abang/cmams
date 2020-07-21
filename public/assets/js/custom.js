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

		$('#entry-table').DataTable( {         
					"ordering": false
				} ); 
	});


	$(document).on('click', '#close-msg', function(e){
		e.preventDefault();
		$(this).parent('div').fadeOut(1000);
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

  // select case managers based on facility choosen
  $(document).on('change', '.sel_facility', function(){
    var handler = $('.case_managers_select');
    var route = $(handler).attr('title');
    var facility_id = $(this).val();
    $(handler).empty();
    console.log(facility_id);
    $(handler).attr('disabled',true);
    $('.loading-img').css('display','inline');
    var csrf_token = $('#csrf_area').attr('content');
      $.ajax({
              type : "GET",
              url : route,
              data : { id : facility_id, _token : csrf_token},
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
              }
      });
  });
})( jQuery );