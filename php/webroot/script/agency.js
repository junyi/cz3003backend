$("#agency_modal").on('hidden.bs.modal', function () {
	$('#agency_modal').removeData('bs.modal');
	$('#agency_modal .modal-content').empty();
	$('#agency_modal .modal-content').html(
		$('<div class="modal-body"></div>').html(
	            $('<div class="progress progress-popup"></div>').html(
	              '<div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>'
	            )
	    )
	);
});

$('#agency_modal').on('loaded.bs.modal', function (e) {


	$('#add_agency_form')
	    .formValidation({
	        framework: 'bootstrap',
	        icon: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	            incidentCategoryTitle: {
	                validators: {
	                    notEmpty: {
	                        message: 'The incident category is required'
	                    }
	                }
	            }
	        }
	    });
})
