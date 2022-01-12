$(document).ready(function()
{
  'use strict';
  var g;
/*
* ----------------------------------------------------------------------------------------
* 01. Pjax + NProgress Config
* ----------------------------------------------------------------------------------------
*/
  $(document).pjax('a[data-pjax]', '#pjax-container', { fragment: '#pjax-container'});
  $(document).on('pjax:clicked', function(e) {
     var g = e.target;
     var pjax_url = $(g).attr("href");
     // Template Config
     var TEMPLATE_CONFIG = {};
     if (pjax_url == '/app-admin') {
       TEMPLATE_CONFIG["files"] = {
         css : ["google/google.min.css"],
         js  : ["libs/sticky-kit/jquery.sticky-kit.min.js"],
       }
     }else if (pjax_url == '/app-admin/users') {
       TEMPLATE_CONFIG["files"] = {
         css : ["/dist/dashboard/vendor/datatables/dataTables.bootstrap4.min.css",
                "/dist/dashboard/vendor/datatables/buttons/css/buttons.bootstrap4.min.css"
               ],
         js  : ["/dist/dashboard/vendor/datatables/jquery.dataTables.min.js",
                "/dist/dashboard/vendor/datatables/dataTables.bootstrap4.min.js",
                "/dist/dashboard/vendor/datatables/buttons/js/dataTables.buttons.min.js",
                "/dist/dashboard/vendor/datatables/buttons/js/buttons.bootstrap4.min.js",
                "/dist/dashboard/vendor/datatables/jszip/jszip.min.js",
                "/dist/dashboard/vendor/datatables/pdfmake/pdfmake.min.js",
                "/dist/dashboard/vendor/datatables/pdfmake/vfs_fonts.js",
                "/dist/dashboard/vendor/datatables/buttons/js/buttons.html5.min.js",
                "/dist/dashboard/vendor/datatables/buttons/js/buttons.print.min.js",
                "/dist/dashboard/vendor/datatables/buttons/js/buttons.colVis.min.js",
                "/dist/dashboard/vendor/datatables/datatable.config.js",
               ],
       }
     }
     // Css Modefaier
     var addingCSS = (TEMPLATE_CONFIG.files.css);
     var newCss = '';
     $.each( addingCSS, function( index, value ){
      newCss += '<link type="text/css" rel="stylesheet" href="'+ value +'" async>';
     });
     var cssLinks = window.document.getElementsByTagName('link');
     var lastCcsLinks = $(cssLinks).last();
     $('#css_files').remove();
     $(lastCcsLinks).before('<span id ="css_files"></span>');
     $('#css_files').append(newCss);

     // JS Modefaier
     var addingJS = (TEMPLATE_CONFIG.files.js);
     var newJS = '';
     $.each( addingJS, function( index, value ){
      newJS += '<script type="text/javascript" src="'+value+'" async><\/script>';

     });
     var jsLinks = document.getElementsByTagName('script');
     var lastEl = jsLinks[jsLinks.length-2];

     $('#js_files').remove();
     $(lastEl).before('<span id ="js_files"></span>');
     $('#js_files').append(newJS);
   });
  $(document).on('pjax:start', function() {
     NProgress.start();
   });

  $(document).on('pjax:end',   function() {
    setTimeout(function() {
       NProgress.done(); $('.fade').removeClass('out');
    }, 300);

  });

});
