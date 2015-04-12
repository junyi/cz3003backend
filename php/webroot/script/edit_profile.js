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
                        message: 'The email address is not valid'
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

$('#change_password_form')
    .formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            old_password: {
                validators: {
                    notEmpty: {
                        message: 'This field is required'
                    },
                    stringLength: {
                        message: 'The password length should be between 6-12 characters',
                        max: 12,
                        min: 6
                    }
                }
            },
            new_password: {
                validators: {
                    notEmpty: {
                        message: 'This field is required'
                    },
                    stringLength: {
                        message: 'The password length should be between 6-12 characters',
                        max: 12,
                        min: 6
                    }
                }
            },
            confirm_password: {
                validators: {
                    notEmpty: {
                        message: 'This field is required'
                    },
                    identical: {
                        field: 'new_password',
                        message: 'The password and its confirmation are not the same'
                    }
                }
            }
        }
    });