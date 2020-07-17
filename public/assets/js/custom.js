"use strict";
(function ($) {
	$(document).ready(function() {
		// if (page_data.facility_reg_valid_fail) {
		// 	$("#add-facility-form").modal("show");
		// }

		$('#facilities-table').DataTable( {         
					"ordering": false
				} ); 
	});


	$(document).on('click', '#close-msg', function(e){
		e.preventDefault();
		$(this).parent('div').fadeOut(1000);
	});

	// Delete facility
	$(document).on('click', '.delete-btn', function(e){
		var handler = $(this);
        var facility_id = handler.attr('id');
        var csrf_token = $('#csrf_area').attr('content');
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
                    type : "GET",
                    url : "http://127.0.0.1:8000/facility/destroy/"+facility_id+'&_token='+csrf_token,
                    data : {facility_id, _token : csrf_token},
                    success: function(data){
                    	$(handler).closest('tr').fadeOut(500, function(){
                    		swal("Facility deleted", {
			            	type: "success",
			                });
                    	});
                    	
                    }
                });
            
              }
        });
        
	});
})( jQuery );