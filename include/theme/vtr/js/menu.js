jQuery(document).ready(function() { 
jQuery("#access ul ul").css({display: "none"}); // Opera Fix 
jQuery("#access li").hover(function(){ 
jQuery(this).find('ul:first').css({visibility: "visible",display: "none"}).show(250); 
},function(){ 
jQuery(this).find('ul:first').css({visibility: "hidden"}); 
}); 
}); 

 

