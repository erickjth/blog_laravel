/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var APP = APP || {};

APP.entry = {
    
    /**
     * Register handler for pagination ajax, using hash url
     */
    register_local_handler: function() {
        //Anonymus function for get hash number for entry page
        var page_hash = function() {
            if (window.location.hash) {
                var page_hash = window.location.hash.replace('#', '');
                if (page_hash != Number.NaN || page_hash > 0) {
                    return page_hash;
                }
                return false;
            }
        }

        //Get has for page load
        $(window).on('hashchange', function() {
            APP.entry.get_entries(page_hash());
        });

        //Init hash
        APP.entry.get_entries(page_hash());

        //Get hash in url from pagination link for load ajax page.
        $(document).on('click', '.pagination a', function(e) {
            var page = $(this).attr('href').split('page=')[1];
            //Set location, and force run hashchange handler :)
            location.hash = page;
            e.preventDefault();
        });
    },
    /*
     * Function for get entries content by page via ajax, with hash url
     * @param page
     */
    get_entries: function(page){
        //if is no set page, init page in 1
        if (!page) {
            //Set hash in URL
            location.hash = 1;
            //Prevent run this function twice, and run handler hashchange
            return;
        }
        //Load content HTML in container
        $( "#entry_list" ).load(route.get_entries+"?page=" + page, function(){
            location.hash = page;
        });
    }
};

/*
 * Register in document, all global handler for the Aplication
 */
APP.register_global_handler = function(){
    
    $(document).on('click', '.load_modal', function (e) {
        var a = $(this);
        var href = a.attr("href");
        $( "#content_loaded" ).load(href+" #content_wrap", function(){
            $('#modal_view').modal('show');
        });
        e.preventDefault();
    });
    
    //On modal is completly hidden, clear content element
    $('#modal_view').on('hidden.bs.modal', function(e) {
        $( "#content_loaded" ).empty();
    });
    
    
};


$(document).ready(function(){
    APP.register_global_handler();
});