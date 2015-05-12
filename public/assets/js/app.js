/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var APP = APP || {};

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
    
    $('.editor').wysihtml5({
        toolbar: {
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": true, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": true, //Button to change color of font  
            "blockquote": true, //Blockquote  
            "size": 'xs' //default: none, other options are xs, sm, lg
        }

    });
};

APP.notify = function (title, message, type) {
    $.notify({
        title: title,
        message: message
    }, {
        type: type,
        delay: 3000,
    });
}


$(document).ready(function(){
    APP.register_global_handler();
    moment.locale('en');
});