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

var oTable = $('#incidentTable').DataTable({
    searching: true,
    dom: '<"hidden"f>tp',
    processing: true,
    serverSide: true,
    ajax: "/admin/incident.json",
    columnDefs: [
        {
            "searchable": false,
            "orderable": false,
            "targets": 0,
            "data": null,
        },
        { 
            "name": "incidentTitle", 
            "targets": 1
        },
        { 
            "name": "incidentDateTime", 
            "targets": 2
        },
        { 
            "name": "address", 
            "targets": 3
        },
        { 
            "name": "incidentCategoryTitle", 
            "targets": 4
        },
        { 
            "name": "incidentStatus", 
            "targets": 5,
            "render": function ( data, type, full, meta ) {
            	var label = "";
            	switch (data) {
				case 'On-going':
					label = "success";
					break;
				case 'Closed':
					label = "danger";
					break;
				case 'Pending':
					label = "warning";
					break;
				default:
					break;
				}
				return "<span class=\"label label-"+label+"\">"+data+"</span>";
            }
        },
        { 
            "name": "action", 
            "targets": 6,
            "data": null,
            "render": function ( data, type, full, meta ) {
            	var id = full['DT_RowId'];
            	return '<a href="#" data-toggle="modal" data-remote="/admin/incident/form?action=edit&id='+id+'" data-target="#incident_modal"> Edit </a> | <a href="/admin/incident/delete?id='+id+'" onclick="return confirm(\'Confirm delete?\');">Delete</a>'
		    }
        }
    ],
    order: [
        [5, 'asc'],
        [2, 'asc']
    ]
});

oTable.on( 'order.dt search.dt', function () {
    oTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    } );
} ).draw();

$('#table_search').keyup(function(){
      oTable.search($(this).val()).draw();
})

$('#footer').append($(".dataTables_paginate"));


// $('#incident_modal').on('shown.bs.modal', function() {
//     $('#incident_modal').formValidation('resetForm', true);
// });
