$("#incidentCategory_modal").on('hidden.bs.modal', function () {
	$('#incidentCategory_modal').removeData('bs.modal');
	$('#incidentCategory_modal .modal-content').empty();
	$('#incidentCategory_modal .modal-content').html(
		$('<div class="modal-body"></div>').html(
	            $('<div class="progress progress-popup"></div>').html(
	              '<div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>'
	            )
	    )
	);
});

$('#incidentCategory_modal').on('loaded.bs.modal', function (e) {


	$('#add_incident_form')
	    .formValidation({
	        framework: 'bootstrap',
	        icon: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	            incidentTitle: {
	                validators: {
	                    notEmpty: {
	                        message: 'The title is required'
	                    }
	                }
	            },
	            incidentDateTime: {
	                validators: {
	                    date: {
	                        format: 'DD/MM/YYYY hh:mm A',
	                        message: 'The value is not a valid date'
	                    },
	                    notEmpty: {
	                        message: 'The location is required'
	                    }
	                }
	            },
	            address: {
	                validators: {
	                    notEmpty: {
	                        message: 'The location is required'
	                    }
	                }
	            }
	        }
	    });

	$('#incident_datetime_input').on('dp.change dp.show', function(e) {
	    $('#add_incident_form').formValidation('revalidateField', 'incident_datetime');
	});
})


// $('#incident_modal').on('shown.bs.modal', function() {
//     $('#incident_modal').formValidation('resetForm', true);
// });
