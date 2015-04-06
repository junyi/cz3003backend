$('#incident_datetime_input').datetimepicker({
	format: 'DD/MM/YYYY hh:mm A'
});

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


// $('#incident_modal').on('shown.bs.modal', function() {
//     $('#incident_modal').formValidation('resetForm', true);
// });
