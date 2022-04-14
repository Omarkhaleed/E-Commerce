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
   /*
      

    i will cancel the asterrisk sometimes untill update the rest of forms in back
      $('input').each(function () {
        if ($(this).attr('required') === 'required') {
            $(this).after('<span class ="asterisk">*</span>');
        }
    
    });
    */
    

    /*
    //there is error logic this function is true but not working
         function myFunction(){
             var x=document.getElementById("myInput");
             if(x.type == "password"){
                 x.type="text";
             }
             else{
                 x.type="password";
             }
         }
*/
        
         // show the password when hover
         // we use the type of field not name
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

       setTimeout(function(){
        $('.period').hide()
    }, 5000) 
       
    $('.live-name').keyup(function(){
       $('.live-preview .caption h3').text($(this).val());
         

    });
    $('.live-desc').keyup(function(){
        $('.live-preview .caption p').text($(this).val());
          
 
     });
     $('.live-price').keyup(function(){
        $('.live-preview .price-tag').text('$'+$(this).val());
          
     });
     // this is a brief way instead of making three function for every class
    // we make it through the data-class attribute  but doesnt work !!!! 
    $('.live').keyup(function(){
       $($(this).data('class')).text($(this).val());
        
    });

});