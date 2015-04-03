$("#incident_category_modal").on('hidden.bs.modal', function () {
	$('#incident_category_modal').removeData('bs.modal');
	$('#incident_category_modal .modal-content').empty();
	$('#incident_category_modal .modal-content').html(
		$('<div class="modal-body"></div>').html(
	            $('<div class="progress progress-popup"></div>').html(
	              '<div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>'
	            )
	    )
	);
});

$('#incident_category_modal').on('loaded.bs.modal', function (e) {


	$('#add_incident_category_form')
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
