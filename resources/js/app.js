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
        style: '/css/sceditor.content.css',
        toolbar: 'bold,italic,underline,strike|bulletlist,orderedlist,quote,code|image,link,unlink|maximize',
    })
}

$(document).ready(function () {
    init_baffle()
    // open_notifications_socket()
});
