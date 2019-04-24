$(function() {
	 // display the all records when DOM will be fully loaded
	 fetchDetails();

// adding data tto dbb
	 $("#addItemForm").on('submit', function(event) {
	 	event.preventDefault();

	 	 let formData = new FormData();
	 	 formData.append('firstname', $('#firstname').val() );
	 	 formData.append('lastname', $('#lastname').val() );
	 	 formData.append('email', $('#email').val() );
	 	 formData.append('phone', $('#phone').val() );
	 	 formData.append('address', $('#address').val() );
	 	 formData.append('photo', $('input[type=file]')[0].files[0] );

// send to server
          $.ajax({
			    url: 'process/backend.php',
			    data: formData,
			    type: 'POST',
			    enctype:'multipart/form-data',
			    dataType:'json',
			    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
			    processData: false, // NEEDED, DON'T OMIT THIS
			    success: function (data) {
			         console.log(data);
			         if (data.status==="fn") {
			         	$("output.fn").addClass('text-danger');
			         	$("output.fn").text(data.message);
			         }
			         else  if (data.status==="ln") {
			         	$("output.ln").addClass('text-danger');
			         	$("output.ln").text(data.message);
			         	$("output.fn").removeClass('text-danger');
			         	$("output.fn").text("");
			         }
			          else  if (data.status==="em") {
			          	$("output.ln").removeClass('text-danger');
			         	$("output.ln").text('');
			         	
			         	$("output.em").addClass('text-danger');
			         	$("output.em").text(data.message);
			         } 
			          else  if (data.status==="ph") {
			          	  	$("output.em").removeClass('text-danger');
			         	$("output.em").text("");

			         	$("output.ph").addClass('text-danger');
			         	$("output.ph").text(data.message);
			         }
			          else  if (data.status==="add") {
			          	$("output.ph").removeClass('text-danger');
			         	$("output.ph").text('');

			         	$("output.add").addClass('text-danger');
			         	$("output.add").text(data.message);
			         } 
			         else if (data.status==="picerror") {
			         	$("output.picerror").addClass('text-danger');
			         	$("output.picerror").text(data.message);
			         }
			         else if (data.status==="success") {
			         	  
			         	       my_toastr_message()
                                toastr.success(data.message);

                            $('#addItemForm').trigger("reset");
				                $('.modal').each(function(){
				                    $(this).modal('hide');
				                });
 
			         	    fetchDetails();
			         	    
			         }

			    },
			    error: function (errors) {
			    	console.error(errors);
			    }
			}); 



	 });

	
// my toastr message
 function my_toastr_message () {
			  	             		 toastr.options = {
										        "closeButton": false,
										        "debug": false,
										        "newestOnTop": false,
										        "progressBar": true,
										        "positionClass": "toast-top-right",
										        "preventDuplicates": true,
										        "onclick": null,
										        "showDuration": "100",
										        "hideDuration": "1000",
										        "timeOut": "5000",
										        "extendedTimeOut": "1000",
										        "showEasing": "swing",
										        "hideEasing": "linear",
										        "showMethod": "show",
										        "hideMethod": "hide"
					    };
			      }


	 // fetching the all content
	 
	 function fetchDetails () {
	 	 
	 	let fetch_details = "read_record";
	 	$.ajax({
	 	 	url: './process/fetch.php',
	 	 	type: 'POST',
	 	 	dataType: 'json',
	 	 	data: {fetchDetails: fetch_details},
	 	 	success: function (response) {
	 	 		console.log(response);
	 	 		$("#all_fetch_details").html(response.template);
	 	 	}
	 	 });
	 	  
	 }

 



	 // delete user

	 $(document).on('click', '#deleteUserNow', function(event) {
	 	event.preventDefault();
	 	 	  let confirmed = confirm("Are your sure want to delete this record.?");
			  if (confirmed) {

			  	let id = $(this).attr('data-id');

			  	let obj = this;

			  	$.ajax({
			  		url: './process/deleterow.php',
			  		type: 'POST',
			  		dataType: 'json',
			  		data: {deleteId: id},
			  		success: function (data, status) {
			  			  console.log(data);
			  	            if (data.status==="success") {
			  	                my_toastr_message();
                                toastr.success('user deleted');
                                fetchDetails();
			  	            }  
			  	            
			  		},
			  		error: function (error) {
			  			console.error(error);
			  		}


			  	});
			  	

			 
			  }

	 });



/*Fetch the data for updatw*/
$(document).on('click', '#getUserDetails', function(event) {
	event.preventDefault();
	  let confirmed = confirm("Are your sure want to edit this records");
			  if (confirmed) {

			  	let id = $(this).attr('data-id');
                
                $('#hidden_user_id').val(id);


                 $.post('./process/update.php', {id: id}, function(data, textStatus, xhr) {
                 	let userData = JSON.parse(data);
                     console.log(userData);
                 	$("#ufirstname").val(userData.firstname);
                 	$("#ulastname").val(userData.lastname);
                 	$("#uemail").val(userData.email);
                 	$("#uphone").val(userData.phone);
                 	$("#uaddress").val(userData.address);
                 	let photo_path = "./userprofile/"+userData.photo;
                 	$("#existphoto").attr('src',photo_path);
                 });

                 // fetch data then show modal;
                $("#updateModal").modal('show');

			 }



});


/* now update the current data*/
$('#updateItemForm').on('submit', function(event) {
	event.preventDefault();
	  let updateFormData = new FormData();
           
	  	 updateFormData.append('firstname', $('#ufirstname').val() );
	 	 updateFormData.append('lastname', $('#ulastname').val() );
	 	 updateFormData.append('email', $('#uemail').val() );
	 	 updateFormData.append('phone', $('#uphone').val() );
	 	 updateFormData.append('address', $('#uaddress').val() );
	 	 updateFormData.append('id', $('#hidden_user_id').val() );
	 	 updateFormData.append('photo', $('input[type=file]')[1].files[0] );


        // calling to AJAX
        $.ajax({
        	url: './process/update_and_save.php',
        	type: 'POST',
        	dataType: 'json',
        	data: updateFormData,
        	enctype:'multipart/form-data',
			dataType:'json',
			contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
		    processData: false, 
        	success: function (data) {
        		console.log(data);

			         	      if (data.status==='success') {
					         	      	 my_toastr_message()
		                                toastr.success(data.message);

		                            // $('#addItemForm').trigger("reset");
						                $('.modal').each(function(){
						                    $(this).modal('hide');
						                });
		 
					         	    fetchDetails();
			         	    
			         	      }

        	},
        	error: function (error) {
        		console.error(error);
        	}
        });
        



});

});