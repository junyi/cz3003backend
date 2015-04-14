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