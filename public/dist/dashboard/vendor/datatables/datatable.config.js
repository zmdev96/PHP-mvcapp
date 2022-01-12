$(document).ready(function() {
  'use strict';

  $('#datatable').DataTable({
    "pageLength": 12,
    dom: 'Bfrtip',
    buttons: [
        'print',
        'copyHtml5',
        'pdfHtml5',
        'excelHtml5',
        //'csvHtml5',
        'colvis',

    ]
  });
});
