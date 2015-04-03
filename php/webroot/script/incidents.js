function showModal(header, contentClassID) {
        $('#modal_title').html(header);
        $('#myModal').modal('show');
    }

$('#incident_datetime_input').datetimepicker({
	format: 'DD/MM/YYYY hh:mm A'
});

$('#incident_location_input').geocomplete({
  details: ".details",
  detailsAttribute: "data-geo"
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

$('#add_incident_form').on('shown.bs.modal', function() {
    $('#add_incident_form').formValidation('resetForm', true);
});
