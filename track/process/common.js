var common = {
    init: function(config) {
        /*setTimeout(function(){
            $('#message_div').removeClass('alert-success alert-danger alert-warning alert-info').html('').hide();
        },'5000');*/
    },
    showHideLoader: function(show_hide) {
        if(show_hide == "show"){
            $('#loader_img').show();
        } else {
            $('#loader_img').hide();
        }
    },
    showHideMessage: function(message,time,message_type) {
        /*message_type can be from the following: success, info, warning, danger*/
        message = '<a style="cursor: pointer;" class="mesg-close" onclick="common.showHideMessage(\'hide\');"><img src="" class="btn-close-search" alt=""></a>'+message;
        $('#message_div').addClass('alert-'+message_type).html(message).show();
       /* setTimeout(function(){
            $('#message_div').removeClass('alert-success alert-danger alert-warning alert-info').html('').hide();
        },time);*/
    },
    disableFields: function(){
         $('input[type=text],select,textarea').each(function(){
            $(this).attr('disabled',true);
            $(this).addClass('disabled');
            $(".bootstrap-select").addClass('disabled');
        });
    },
    enableFields: function(){
         $('input[type=text],select,textarea').each(function(){
            $(this).attr('disabled',false);
            $(this).removeClass('disabled');
            $(".bootstrap-select").removeClass('disabled');
        });
    }
};
common.init({});