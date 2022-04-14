// Hide Placeholder On Form Focus
$(function () {

	'use strict';

$('[placeholder]').focus(function () {

    $(this).attr('data-text', $(this).attr('placeholder'));

    $(this).attr('placeholder', '');

}).blur(function () {

    $(this).attr('placeholder', $(this).attr('data-text'));

});
   // ADD Asterisk on required field 
   //old way 
   
      $('input').each(function () {
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class ="asterisk">*</span>');
        }
    
    });
     // show the password when hover
       var passfield=$('.password');
       $('.show-pass').hover(function(){
           passfield.attr('type','text');
       },
       function(){
           passfield.attr('type','password');
       
       });
       //confirmation message on button
       $('.confirm').click(function(){
           return confirm('Are You Sure to delete this member ?');
       });
       //category view option
       $('.cat h3').click(function(){
         $(this).next('.fullview').fadeToggle(200);
       });
       
       $('.option span').click(function(){
           $(this).addClass('active').siblings('span').removeClass('active');
           if($(this).data('view')=== 'full'){
            $('.cat .fullview').fadeIn(200);
           }
           else
           {
            $('.cat .fullview').fadeOut(200);
           }
       });
      

});