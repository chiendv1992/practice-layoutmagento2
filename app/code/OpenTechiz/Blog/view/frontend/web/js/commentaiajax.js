define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    function main(config, element) {
        var $element =$(element);
        var AjaxCommentPostUrl = config.AjaxCommentPostUrl;

        var dataForm=$("#comment-form");
        dataForm.mage('validate',{});
        $(document).on('click','.submit',function(){
            if (dataForm.valid()){
                event.preventDefault();
                var param =  dataForm.serialize();
                alert(param);
                    $.ajax({
                        showLoader : true,
                        url : AjaxCommentPostUrl,
                        type : 'POST'
                    }).done(function (data) {
                        $('.none').html(data);
                        $('.note').css('color','red')
                        document.getElementById('comment-form').reset();
                        return true ;
                    });
                }
        });
    };
    return main;
});
