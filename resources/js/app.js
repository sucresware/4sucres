require('./bootstrap')
require('sceditor/minified/sceditor.min.js')
require('sceditor/minified/formats/bbcode.js')

let $ = require("jquery");
let baffle = require('baffle')

/**
 * Notifications
 */

// open_notifications_socket = function () {
// }

/**
 * Custom BBCode
 */

init_baffle = function () {
    var s = ["█", "▓", "▒", "░", "█", "▓", "▒", "░", "█", "▓", "▒", "░", "<", ">", "/"]
    baffle('.baffle', {
        characters: s
    }).reveal(1000)
}

init_spoilers = function () {
    $('.spoiler').each(function(k, el){
        $(el).on('click', function(e) {
            $(e.target).addClass('show')
        })
    })
}

/**
 * Editor
 */

init_editor = function(el) {
    sceditor.create(el, {
        format: 'bbcode',
        plugins: 'undo',
        startInSourceMode: true,
        emoticonsEnabled: false,
        resizeEnabled: false,
        width: '100%',
        height: '350px',
        style: '/css/sceditor.content.css',
        toolbar: 'bold,italic,underline,strike|bulletlist,orderedlist,quote,code|image,link,unlink|maximize',
    })
}

init_actions = function(){
    $('a[data-action]').each(function(k, el){
        switch ($(el).attr('data-action')){
            case 'quotePost':
                $(el).on('click', function(e) {
                    sceditor.instance(document.getElementById('body')).insertText('#p:' + $(e.target).closest('a').attr('data-id'));
                })
            break;
        }
    })
}

$(document).ready(function () {
    init_spoilers()
    init_baffle()
    init_actions()
    // open_notifications_socket()
});
