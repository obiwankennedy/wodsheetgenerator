/*  Bibliothèque JavaScript version 0.1
 *  Autor: Renaud Guezennec
 *
 * 
 * 
 *
*/

function updateForm()
{
    checkInfoFrame();
    checkAttributFrame();
    //errorMessageToUser("")
    $('#tag').tagsInput({
  autocomplete_url:'http://nwod.rolisteam.org/api/autocomplete'
});
}
function isNumberKey(evt)
{
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;

}
function refreshContent()
{
	         $.ajax({
                            url: "/refreshContent.php",
                            type: "POST",
                            data: $('#general').serialize()
                            }).done(function(msg) {
                                $('#middle').html(msg);
                                        updateForm();
                            });



}
function errorMessageToUser(msg)
{

        $('#dialoguser').css("color","red");
        $('#dialoguser').text(msg);
}
function informationMessageToUser(msg)
{
        $('#dialoguser').css("color","green");
        $('#dialoguser').text(msg);
}
function checkInfoFrame()
{
    var test = $('#ig_name');
    var name = $('#ig_name').val().length;
    var age = $('#ig_age').val().length;
    var player = $('#ig_player').val().length;
    var concept = $('#ig_concept').val().length;
    var field_bottom = $('#field_bottom').val().length;
    var field_top = $('#field_top').val().length;
    var field_middle = $('#field_middle').val().length;
    var virtue = $('#ig_vertue').val().length;
    var vice = $('#ig_vice').val().length;

    var count = 0

    if( name != 0)
        count+=1
    if( age != 0)
        count+=1
    if( player != 0)
        count+=1
    if( concept != 0)
        count+=1
    if( field_bottom != 0)
        count+=1
    if( field_top != 0)
        count+=1
    if( field_middle != 0)
        count+=1
    if( virtue != 0)
        count+=1
    if( vice != 0)
        count+=1

    if(count > 4)
    {
        $('#at_frame').show();
        informationMessageToUser("Congratulations! You can now define attributes for you character");
    }
    else if(count > 0)
    {
        errorMessageToUser("You need to define: "+(5-count)+" more fields");
    }
    
    

}
function checkAttributFrame()
{
    var at_int = $('#at_int').val().length;
    var at_force = $('#at_force').val().length;
    var at_pre = $('#at_pre').val().length;
    var at_ast = $('#at_ast').val().length;
    var at_dex = $('#at_dex').val().length;
    var at_mani = $('#at_mani').val().length;
    var at_res = $('#at_res').val().length;
    var at_vig = $('#at_vig').val().length;
    var at_cal = $('#at_cal').val().length;

    

    if(( at_int != 0) && ( at_force != 0)&&( at_pre != 0)&&( at_ast != 0)&&( at_dex != 0)&&( at_mani != 0)&&( at_res != 0)&&( at_vig != 0)&&( at_cal != 0))
    {
        $('#skill_frame').show();
        informationMessageToUser("Congratulations! You can now define the skills for you character");
    }
    else if(at_int+at_force+at_pre+at_ast +at_dex+at_mani+at_res+at_vig+at_cal == 0)
    {
              informationMessageToUser("First, fullfill the general information");
    }
    else
    {
        errorMessageToUser("");
    }
    

}

 $(document).ready(function() {
 updateForm()
});

