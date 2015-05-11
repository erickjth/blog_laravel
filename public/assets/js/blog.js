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
    
    //$('.editor').wysihtml5();
};

APP.notify = function (title, message, type) {
    $.notify({
        title: title,
        message: message
    }, {
        type: type
    });
}


$(document).ready(function(){
    APP.register_global_handler();
    moment.locale('en');
});