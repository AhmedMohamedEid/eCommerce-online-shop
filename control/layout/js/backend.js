$(function(){

    'use strict';
    // Trigger Select Box
    $('select').selectBoxIt({
        autoWidth : false
        });
    
    //  Dashboard
    $('.toggel-info').click(function(){
       
        $(this).toggleClass("selected").parent().next(".panel-body").fadeToggle(100);
        if($(this).hasClass("selected")){
            $(this).html('<i class="fa fa-minus fa-lg"></i>');
        }else{
            $(this).html('<i class="fa fa-plus fa-lg"></i>');
        }
    });
    
    // Hide The Palceholder on Form Focus in
    $('[placeholder]').focus(function(){
       $(this).attr('data-text', $(this).attr('placeholder'));
       
       $(this).attr('placeholder', '');
       
    }).blur(function(){
        
        $(this).attr('placeholder', $(this).attr('data-text'));
        });
    
    // Add Asterisk on Required Field
    $('input').each(function(){
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="asterisk" >*<s/pan>');
        }
    });
    
    
    
	// Convert Password Field to text Field on Click
	var  passField =  $('.password');
	
	$('.show-pass').hover(function(){
			$(this).attr( 'class','show-pass fa fa-eye fa-1x');
			passField.attr('type' , 'text');
		},function(){
			$(this).attr( 'class','show-pass fa fa-eye-slash fa-1x');
			passField.attr('type', 'password' );
			});

		// Confirmation Message On Button
		$('.confirm').click(function(){
			
			return confirm('Do you want to Delete This Membar?');
			});
		
		// Category View Option
        
		$('.cat h3').click(function(){
			$(this).next('.full-view').fadeToggle(200);
			});
		$('.option span').click(function(){
			$(this).addClass('active').siblings('span').removeClass('active');
			if($(this).data('view') === 'full' ){
				$('.cat .full-view').fadeIn(200);
			}else{
				$('.cat .full-view').fadeOut(200);
			}
			
			});
        
    // Show Delelte Button On Click Cats
    $('.child-link').hover(function(){
            
            $(this).find('.show-delelte').fadeIn();
            
    } , function(){
        
            $(this).find('.show-delelte').fadeOut();
            
    });
    
});