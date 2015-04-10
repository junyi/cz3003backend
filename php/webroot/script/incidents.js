$("#incident_modal").on('hidden.bs.modal', function () {
	$('#incident_modal').removeData('bs.modal');
	$('#incident_modal .modal-content').empty();
	$('#incident_modal .modal-content').html(
		$('<div class="modal-body"></div>').html(
	            $('<div class="progress progress-popup"></div>').html(
	              '<div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>'
	            )
	    )
	);
});

$('#incident_modal').on('loaded.bs.modal', function (e) {
	$('#incident_location_input').geocomplete({
	  details: ".details",
	  detailsAttribute: "data-geo",
	  country: "sg"
	});

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
	            address: {
	                validators: {
	                    notEmpty: {
	                        message: 'The location is required'
	                    }
	                }
	            }
	        }
	    });
})


// $('#incident_modal').on('shown.bs.modal', function() {
//     $('#incident_modal').formValidation('resetForm', true);
// });
