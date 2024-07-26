jQuery(document).ready(function($) {
   $('#export_scorm').click(function() {
       var courseId = $(this).data('course-id');
       
       $.ajax({
           url: SCORM_AJAX.ajax_url,
           type: 'POST',
           data: {
               action: 'export_course_scorm',
               course_id: courseId
           },
           success: function(response) {
               alert('File is ready for download!');
               window.location.href = response;
               console.log( response.data );
           },
           error: function() {
               alert('Error: Unable to export course.');
           }
       });
   });
});
