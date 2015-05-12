/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Object for User
 * @type type
 */
APP.user = {
    
    user: user,
    
    /**
     * Register handler
     */
    
    register_local_handler: function() {
        var me = this;
        $("#sync_tweets").click(function(e) {
            me.sync_tweets();
            e.preventDefault();
        });
        $(document).on('click', 'a.hide_tweet', function(e) {
            var twid = $(this).data("twid");
            me.toggle_tweet(twid);
            e.preventDefault();
        });
        
        //Get hash in url from pagination link for load ajax page.
        $(document).on('click', '#twitter_timeline + .pager a', function(e) {
            var page = $(this).attr('href').split('page=')[1];
            me.get_tweets(page);
            e.preventDefault();
        });
        
    },
    
    append_paginator_tweets: function(data){
        var timeline = $("#twitter_timeline");
        var ele = $("<div></div>", {class: 'pager '});
 
        if( data.current_page > 1 ){
            ele.append('<li><a href="'+route.get_tweet+'?page='+(data.current_page-1)+'" rel="prev">«</a></li>');
        }
        if( data.to <= data.total && data.current_page != data.last_page){
            ele.append('<li><a href="'+route.get_tweet+'?page='+(data.current_page+1)+'" rel="next">»</a></li>');
        }
        
        timeline.next().remove();
        timeline.parent().append(ele);
    },
    
    procces_tweet: function (list, insert ) {
        var me = this;
        var container = $("#twitter_timeline");
        var ele, content;
        $.each(list, function (i, o) {
            ele = $("<div></div>", {class: 'media '+( (o.is_hidden==1)?"hidden_tweet":""), id: 'tweet_'+o.id });
            ele.append('<div class="media-left"><a target="_blank" href="https://twitter.com/' + o.tw_screen_name + '"><img src="' + o.tw_profile_image_url + '"/></a></div>');
            content = $("<div></div>", {class: 'media-body'});
            content.append('<span class="user_name">' + o.tw_name + '</span>');
            content.append('<span class="screen_name"><a target="_blank"  href="https://twitter.com/' + o.tw_screen_name + '">@' + o.tw_screen_name + '</a></span>');
            if( auth_user.hasOwnProperty('id') && auth_user.id == me.user.id ){
                content.append('<a class="hide_tweet pull-right" data-twid="'+o.id+'" target="_blank" href="javascript:void(0);"><span class="glyphicon glyphicon-eye-open"></span></a>');
            }
            content.append('<p class="date">' + moment.unix(o.tw_created_at).format('MMMM Do YYYY, h:mm:ss a') + '</p>');
            content.append('<p class="text">' + o.tw_text + '</p>');
            ele.append(content);
            
            if( insert == -1 ){
                container.prepend(ele);
            }else{
                container.append(ele);
            }
        });
        //Convert URL linkable
        $('#twitter_timeline').linkify();
    },
    
    /*
     * Function for get entries content by page via ajax, with hash url
     * @param page
     */
    get_tweets: function(page){
        var me = this;
        //if is no set page, init page in 1
        if (!page || page == "undefined") {
            page = 1;
        }
        //Clear list
        $('#twitter_timeline').empty();
        //Get tweets via ajax
        $.ajax({
            url: route.get_tweet,
            dataType: 'json',
            data: {page: page}
        }).done(function (response) {
            if( response.success ){
                if( response.data.total > 0 ){
                    me.procces_tweet(response.data.data,1);
                    me.append_paginator_tweets(response.data);
                    APP.notify('',response.message,'info');
                }else{
                    me.sync_tweets();
                }
            }else{
                APP.notify('',response.message,'danger');
            }
        });
    },
    
    sync_tweets: function(){
        var me = this;
        $.ajax({
            url: route.sync_tweets,
            dataType: 'json',
            method: 'POST',
        }).done(function (response) {
            if( response.success ){
                var type = "info";
                if( response.total > 0 ){
                    me.procces_tweet(response.data,-1);
                    type = "success"
                }
                APP.notify('',response.message,type);
            }else{
                APP.notify('',response.message,'danger');
            }
        });
    },
    
    toggle_tweet: function(id){
        var me = this;
        var ele = $("#tweet_"+id);
        $.ajax({
            url: route.toggle_tweet,
            dataType: 'json',
            method: 'POST',
            data: {twid: id}
        }).done(function (response) {
            if( response.success ){
                if( response.data.is_hidden==1 ){
                    ele.addClass("hidden_tweet");
                }else{
                    ele.removeClass("hidden_tweet");
                }
                APP.notify('',response.message,'info');
            }else{
                APP.notify('',response.message,'danger');
            }
        });
    },
    
    init: function(){
        var me = this;
        this.register_local_handler();
        this.get_tweets();
        setInterval(function(){ me.sync_tweets()  }, 60000);
    },
};