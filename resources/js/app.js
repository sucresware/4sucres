require('./bootstrap')
require('sceditor/minified/sceditor.min.js')
require('sceditor/minified/formats/bbcode.js')
require('select2')

let $ = require("jquery")
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
    $('.spoiler').each(function (k, el) {
        $(el).on('click', function (e) {
            $(e.target).addClass('show')
        })
    })
}

init_select2 = function () {
    $('.select2').each(function (k, el) {
        $(el).select2({
            theme: 'bootstrap4',
        })
    })
}

/**
 * Editor
 */

$(document).on("mousedown", "[data-bbcode]", function () {
    var editor = $("." + $(this).parent(".btn-group").parent(".editor-buttons").attr("data-parent"))
    var str = $(editor).val()
    var selection = getInputSelection($(editor))
    if (selection.length > 0) {
        $(editor).val(str.replace(selection, "[" + $(this).attr("data-bbcode") + "]" + selection + "[/" + $(this).attr("data-bbcode") + "]"))
    } else {
        $(editor).val(str + "[" + $(this).attr("data-bbcode") + "]" + "[/" + $(this).attr("data-bbcode") + "]")
    }
})

init_actions = function () {
    $('[data-action]').each(function (k, el) {
        $(el).off('click')
        $(el).on('click', function (e) {
            switch ($(el).attr('data-action')) {
                case 'quotePost':
                    editor = $(".sucresBB-editor")
                    var str = $(editor).val()
                    $(editor).val(str + '#p:' + $(e.target).closest('a').attr('data-id') + ' ')

                    break;
                case 'openRisibank':
                    risibank.init()
                    break;
                case 'insertRisibank':
                    let src = $(e.target).closest('a').attr('data-src')

                    editor = $(".sucresBB-editor")
                    var str = $(editor).val()
                    $(editor).val(str + "[img]" + src + "[/img]")
                    $("#risibank").modal('hide')

                    break;
                case 'openNoelshack':
                    noelshack.init()
                    break;
            }
        })
    })
}

let risibank = {
    init: function () {
        $("#risibank-searchfield").off('keypress')
        $("#risibank-searchfield").off('click')

        $("#risibank-searchfield").keypress(function (e) {
            var keycode = (e.keyCode ? e.keyCode : e.which)
            if (keycode == '13') {
                e.preventDefault()
                risibank.search()
            }
        })
        $("#risibank-searchaction").click(function (e) {
            e.preventDefault()
            risibank.search()
        })

        risibank.load()
    },
    load: function () {
        $popular = $("#risibank-popular")
        $latest = $("#risibank-latest")
        $random = $("#risibank-random")
        risibank.setLoader($popular)
        risibank.setLoader($latest)
        risibank.setLoader($random)

        $.getJSON('https://cors-anywhere.herokuapp.com/https://api.risibank.fr/api/v0/load')
            .done(function (resp) {
                risibank.setStickers(resp.stickers.views, $popular)
                risibank.setStickers(resp.stickers.tms, $latest)
                risibank.setStickers(resp.stickers.random, $random)
                init_actions()
            })
            .fail(function () {
                risibank.setError($popular)
                risibank.setError($latest)
                risibank.setError($random)
            })
    },
    search: function () {
        $search = $("#risibank-search")
        risibank.setLoader($search)

        $.ajax({
            type: 'POST',
            url: 'https://cors-anywhere.herokuapp.com/https://api.risibank.fr/api/v0/search?search=' + $("#risibank-searchfield").val(),
            success: function (resp) {
                risibank.setStickers(resp.stickers, $search)
                init_actions()
            },
            error: function () {
                risibank.setError($search)
            }
        })
    },
    setStickers: function (stickers, $el) {
        $el.empty()
        stickers.forEach(sticker => {
            $el.append('<a href="javascript:void(0)" data-action="insertRisibank" data-src="' + sticker.risibank_link + '"><img src="' + sticker.risibank_link + '" style="max-width: 68px; max-height: 51px; margin: 3px; cursor: pointer;" class="img-thumbnail"></a>')
        })
    },
    setLoader: function ($el) {
        $el.empty()
        $el.append('<div class="my-5"><i class="fas fa-sync fa-spin fa-1x"></i></div>')
    },
    setError: function ($el) {
        $el.empty()
        $el.append('<div class="my-5"><i class="fas fa-exclamation-circle text-danger fa-1x"></i></div>')
    }
};

let noelshack = {
    init: function () {
        $("#noelshack-uploadaction").off('click')
        $("#noelshack-uploadaction").click(function (e) {
            e.preventDefault()
            noelshack.upload()
        })
        noelshack.clearError()
        noelshack.setForm()
    },
    upload: function () {
        noelshack.clearError()
        noelshack.setProgress(0)

        var formData = new FormData();
        formData.append('fichier', $("#noelshack-uploadinput")[0].files[0])

        $.ajax({
            type: 'POST',
            url: "https://cors-anywhere.herokuapp.com/https://www.noelshack.com/api.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        noelshack.setProgress(Math.round(percentComplete*100))
                    }
                }, false)
                return xhr
            },
            success: function (resp) {
                console.log(resp)
                if (resp == "Une erreur s'est produite lors du transfert du fichier !" ||
                    resp == "Le type du fichier n'est pas autorisé !" ||
                    resp == "Le fichier est trop volumineux. (max : 4 Mo)") {
                    noelshack.setError(resp)
                    noelshack.setForm()
                } else {
                    editor = $(".sucresBB-editor")
                    var str = $(editor).val()
                    $(editor).val(str + "[img]" + resp + "[/img]")
                    $("#noelshack").modal('hide')
                }
            },
            error: function (resp) {
                console.log(resp)
                noelshack.setError(resp)
            }
        })
    },
    setForm: function () {
        noelshack.hideAll()
        $('#noelshack-form').show()
        $('#noelshack-upload').show()
        $('#noelshack-uploadinput').val('')
    },
    setProgress: function (percent) {
        noelshack.hideAll()
        $('#noelshack-progress').show()
        percent = '<i class="fas fa-sync fa-spin fa-1x mr-1 mb-2"></i><br>' + percent + "%";
        $('#noelshack-progress').html(percent)
    },
    setError: function (str) {
        $('#noelshack-error').show()
        str = '<i class="fas fa-exclamation-circle fa-1x mr-1"></i>' + str;
        $('#noelshack-error').html(str)
    },
    clearError: function(){
        $('#noelshack-error').hide()
        $('#noelshack-error').empty()
    },
    hideAll: function () {
        $('#noelshack-progress').hide()
        $('#noelshack-form').hide()
    }
};

$(document).ready(function () {
    init_spoilers()
    init_baffle()
    init_actions()
    init_select2()
    // open_notifications_socket()
})

function getInputSelection(elem) {
    if (typeof elem != "undefined") {
        s = elem[0].selectionStart;
        e = elem[0].selectionEnd;
        return elem.val().substring(s, e)
    } else {
        return '';
    }
}
