var oTable = $('#incidentTable').DataTable({
    searching: true,
    dom: '<"hidden"f>tp',
    processing: true,
    serverSide: true,
    ajax: "/incident.json",
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
        }
    ],
    order: [
        [1, 'asc']
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
