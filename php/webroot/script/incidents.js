function notify(message, success) {
	$.notify({
			// options
			message: message
		},{
			// settings
			type: success ? 'success' : 'danger',
			delay: '2000',
			timer: '100',
			placement: {
				from: "top",
				align: "center"
			},
			animate: {
				enter: 'animated fadeInDown',
				exit: 'animated fadeOutUp'
			}
		});
}

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
	// Ladda.bind( 'input[type=submit]' );
	var l = Ladda.create( $('.ladda-button')[0] );

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
	    })
	    .on('success.form.fv', function(e) {
            // Prevent form submission
            e.preventDefault();

            l.start();

            var $form = $(e.target),
                fv    = $form.data('formValidation');

            // Use Ajax to submit form data
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                success: function(result) {
                	$("#incident_modal").modal('hide');
            		notify(result.message, result.success);
            		oTable.clearPipeline();
            		oTable.ajax.reload(null, false);
            		$('#'+String(result.id)).addClass('flash');
	    			setTimeout( function() { 
	    				$('#'+String(result.id)).removeClass('flash');
	    			}, 1500);

                    // ... Process the result ...
                }
            });
        });
})

function deleteItem(e) {
    e.preventDefault();

	if (confirm('Confirm delete?')){
		var form = $(e.currentTarget);
		$.ajax({
	        url: form.attr('href'),
	        type: 'GET',
	        success: function(result) {
	        	result = JSON.parse(result);
	    		notify(result.message, result.success);
	    		oTable.clearPipeline();
        		oTable.ajax.reload(null, false);
	    		
	        }
	    });
	}
}

function toggleStatus(newStatus, e) {
	e.preventDefault();

	if (confirm('Change status to '+ newStatus +'?')){
		var form = $(e.currentTarget);
		$.ajax({
	        url: form.attr('href'),
	        type: 'GET',
	        success: function(result) {
	        	result = JSON.parse(result);
	    		notify(result.message, result.success);
	    		oTable.clearPipeline();
        		oTable.ajax.reload(null, false);
	        }
	    });
	}
}

//
// Pipelining function for DataTables. To be used to the `ajax` option of DataTables
//
$.fn.dataTable.pipeline = function ( opts ) {
    // Configuration options
    var conf = $.extend( {
        pages: 5,     // number of pages to cache
        url: '',      // script url
        data: null,   // function or object with parameters to send to the server
                      // matching how `ajax.data` works in DataTables
        method: 'POST' // Ajax HTTP method
    }, opts );
 
    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;
 
    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;
         
        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
         
        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );
 
        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));
 
                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }
             
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);
 
            request.start = requestStart;
            request.length = requestLength*conf.pages;
 
            // Provide the same `data` options as DataTables.
            if ( $.isFunction ( conf.data ) ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }
 
            settings.jqXHR = $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);

                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    json.data.splice( requestLength, json.data.length );
                     
                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );
 
            drawCallback(json);
        }
    }
};
 
// Register an API method that will empty the pipelined data, forcing an Ajax
// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
$.fn.dataTable.Api.register( 'clearPipeline()', function () {
    return this.iterator( 'table', function ( settings ) {
        settings.clearCache = true;
    } );
} );

var oTable = $('#incidentTable').DataTable({
    searching: true,
    dom: '<"hidden"f>rtp',
    processing: true,
    serverSide: true,
    ajax: $.fn.dataTable.pipeline( {
        url: "/admin/incident.json",
        pages: 5, // number of pages to cache
        type: "POST"
    }),
    language: {
    	"processing": '<i class="fa fa-refresh fa-2x fa-spin"></i>'
	},
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
            	var id = full['DT_RowId'];
            	var newStatus = data === "On-going" ? "Closed" : "On-going";
				return "<a href=\"/admin/incident/toggleStatus?id="+id+"\" onclick=\"return toggleStatus('"+newStatus+"',event);\"><span class=\"label label-"+label+"\">"+data+"</span></a>";
            }
        },
        { 
            "name": "action", 
            "targets": 6,
            "data": null,
            "render": function ( data, type, full, meta ) {
            	var id = full['DT_RowId'];
            	return '<a href="#" data-toggle="modal" data-remote="/admin/incident/form?action=edit&id='+id+'" data-target="#incident_modal"> Edit </a> | <a href="/admin/incident/delete?id='+id+'" onclick="return deleteItem(event);">Delete</a>'
		    }
        }
    ],
    order: [
        [5, 'asc'],
        [2, 'asc']
    ]
});

oTable.clearPipeline();

oTable.on( 'order.dt search.dt', function () {
    oTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    } );
} ).draw();

$('#table_search').keyup(function(){
      oTable.search($(this).val()).draw();
})

$('#footer').append($(".dataTables_paginate"));

// $('#incidentTable').on('processing.dt', function ( e, settings, processing ) {
// 	console.log("processing");
//     $('#processingIndicator').css( 'display', processing ? 'block' : 'none' );
// });


// $('#incident_modal').on('shown.bs.modal', function() {
//     $('#incident_modal').formValidation('resetForm', true);
// });
