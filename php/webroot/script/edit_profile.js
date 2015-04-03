$('#edit_profile_form')
    .formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The title is required'
                    }
                }
            },
            email: {
                validators: {
                    emailAddress: {
                        message: 'The value is not a valid email address'
                    },
                	notEmpty: {
                        message: 'The email is required'
                    }
                }
            },
            contact: {
                validators: {
                    notEmpty: {
                        message: 'The location is required'
                    },
                    digits: {
                        message: 'The value must consists of only digits'
                    },
                    stringLength: {
                        message: 'The value must be exactly 8 digits',
                        max: 8,
                        min: 8
                    }
                }
            }
        }
    });