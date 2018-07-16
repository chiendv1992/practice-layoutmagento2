define([
    "jquery",
    "mage/template",
    "mage/translate",
    "domReady!"
], function($, mageTemplate) {
    "use strict";

        return {
            loadComments : function(config, data_comment, time){
                var template = mageTemplate('#cmt-not-active');

                var comments = data_comment;
                var newField = template({
                    cmt: {
                        author: data_comment['author'],
                        content: data_comment['content'],
                        creation_time: time
                    }
                });
                $('ul#not-active-new').append(newField);
            },
            loadAjax : function(config){
                var LoadUrl = config.LoadUrl;
                var PostId = config.PostId;
                $.ajax({
                    url: LoadUrl,
                    type: 'POST',
                    data: {
                        post_id: PostId
                    }
                }).done(function(data){
                    var template = mageTemplate('#cmt-not-active');
                    if(data==false) return false;
                    var comments = data.items;
                    comments.forEach(function(cmt){
                        var newField = template({
                            cmt: cmt
                        });

                        $('ul#not-active').append(newField);
                    });
                });
            }
        };
});