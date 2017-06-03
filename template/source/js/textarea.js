$(function(){

    $("#message").keyup(function(event){
        var messageLength = $(this).attr("maxlength")

        var lenValue = $(this).val().length;
        if(lenValue <= messageLength){
            $("#count").html(lenValue);
            if(lenValue == messageLength){
                $(this).siblings(".weui-textarea-counter").css("color","#000");
            }else{

                $(this).siblings(".weui-textarea-counter").css("color","#b2b2b2");
            }
        }
    })

})