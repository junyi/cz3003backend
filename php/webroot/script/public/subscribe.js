$('#subscribe_form')
    .formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            subscriberName: {
                validators: {
                    notEmpty: {
                        message: 'The name field is required'
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
            }
        }
    });