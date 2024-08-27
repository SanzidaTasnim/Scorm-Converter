jQuery(document).ready(function($) {
   // $('.show-more').on('click', function(e) {
   //     e.preventDefault();
   //     var remainingText = $(this).prev('.remaining-text');
   //     console.log( remainingText );
       
   //     if (remainingText.is(':hidden')) {
   //         remainingText.show();
   //         $(this).text('▲');
   //     } else {
   //         remainingText.hide();
   //         $(this).text('▼'); 
   //     }
   // });
   jQuery(document).ready(function($) {
      
      $('.show-more').on('click', function(e) {
          e.preventDefault();
          console.log('Arrow clicked'); 
         var $remainingText = $(this).siblings('.remaining-text');

          
          if ($remainingText.is(':hidden')) {
              $remainingText.show();
              $(this).text('▲');
          } else {
              $remainingText.hide();
              $(this).text('▼');
          }
      });
  });
  
});
