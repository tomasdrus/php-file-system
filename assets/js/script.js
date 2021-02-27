$(document).ready(function() {
    $('#table').DataTable( {
        "paging":   false,
        "searching":   false,
        "info":     false,
        columnDefs: [
            { orderable: false, targets: 4 }
        ],
    } );
} );