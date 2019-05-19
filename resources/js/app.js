require('./bootstrap')
require('select2')
require('@fancyapps/fancybox/dist/jquery.fancybox.min.js')

let $ = require("jquery")
let baffle = require('baffle')
let { Textcomplete, Textarea } = require('textcomplete');
let csrf_token = $("meta[name=csrf-token]").attr('content');

import iziToast from 'izitoast'
import Echo from "laravel-echo"
import bsCustomFileInput from 'bs-custom-file-input'
import VueClipboard from 'vue-clipboard2'
import {
    Howl,
    Howler
} from 'howler';


window.Vue = require('vue');
window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
})

iziToast.settings({
    position: 'topRight'
});

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.mixin({
    data: function () {
        return {
            get auth_user() {
                return window.fourSucres.user;
            }
        }
    },
    methods: {
        auth_user_can: function (permission) {
            return (this.auth_user && this.auth_user.permissions.includes(permission))
        },
        route: route,
    }
})

Vue.use(VueClipboard)

const app = new Vue({
    el: '#app',
});

window.notification_sound = new Howl({
    src: ['/audio/intuition.mp3', '/audio/intuition.mp3'],
    volume: 0.5,
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': csrf_token
    }
});

if (window.fourSucres.user) {
    window.Echo
        .private('App.Models.User.' + window.fourSucres.user.id)
        .notification((notification) => {
            iziToast.success({
                title: notification.title,
                message: notification.html,
                buttons: [
                    ['<button>Voir</button>', function (instance, toast) {
                        window.location.href = notification.url
                    }],
                ],
                balloon: 1,
                layout: 2,
                icon: 'fas fa-asterisk',
                iconColor: '#D08770',
                backgroundColor: '#fff',
                maxWidth: '400px'
            });
            notification_sound.play()
            setAltFavicon()

            if (
                notification.type == 'App\\Notifications\\NewPrivateDiscussion' ||
                (notification.type == 'App\\Notifications\\ReplyInDiscussion' && notification.private)
            ) {
                var markup = '<i class="fas fa-circle fa-stack-2x text-darker"></i>' +
                    '<i class="fas fa-envelope fa-stack-1x fa-inverse"></i>' +
                    '<span class="badge badge-danger">&bullet;</span>'
                $("#private_discussions_indicator").html(markup)
            }

            var markup = '<i class="fas fa-circle fa-stack-2x text-darker"></i>' +
                '<i class="fas fa-bell fa-stack-1x fa-inverse"></i>' +
                '<span class="badge badge-danger">&bullet;</span>'
            $("#notifications_indicator").html(markup)
        })
}

/**
 * Custom BBCode
 */

var init_baffle = function () {
    var s = ["█", "▓", "▒", "░", "█", "▓", "▒", "░", "█", "▓", "▒", "░", "<", ">", "/"]
    baffle('.baffle', {
        characters: s
    }).reveal(1000)
}

var init_spoilers = function () {
    $('.spoiler').each(function (k, el) {
        $(el).on('click', function (e) {
            $(e.target).addClass('show')
        })
    })
}

var init_select2 = function () {
    $('select:visible').each(function (k, el) {
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

let autocomplete = {
    users: undefined,
    regex: /(@|#u:)([\w\d-]+)$/,
    selector: 'textarea.sucresBB-editor',
    init: () => {
        autocomplete.loadUsers().then(() => {
            autocomplete.apply();
        });
    },
    apply: () => {
        $(autocomplete.selector).each(function() {
            let _editor = new Textarea($(this)[0]);
            let _textcomplete = new Textcomplete(_editor);
    
            _textcomplete.register([{
                // Matches @<username> or #u:<id>
                match: autocomplete.regex,
    
                // Calls callback with the search values thanks to search terms
                search: function (term, callback) {
                    callback( autocomplete.filter(term) );
                },
    
                // The way it's rendered in the dropdown
                template: function (name) {
                    return `${name}`;
                },
    
                // The output when user selects in the dropdown
                replace: function (username) {
                  return `@${username} `; 
                }
            }])
        });
    },
    filter: (term) => {
        return $.grep(autocomplete.getUsers(), user => {
            return user.toLowerCase().startsWith(term.toLowerCase());
        });
    },
    loadUsers: () => {
        return new Promise((resolve, reject) => {
            $.get('/api/v0/users/all') // TODO - remove hardcode
             .then(result => {
                autocomplete.users = result;
                resolve();
             })
             .fail(() => {
                reject();
             });
        });
    },
    getUsers: () => {
        return autocomplete.users;
    }
};

var init_actions = function () {
    $('[data-action]').each(function (k, el) {
        var $el = $(el)
        $el.off('click')
        $el.on('click', function (e) {
            switch ($el.attr('data-action')) {
                case 'gotoDiscussion':
                    if ($el.is('a') || $el.is('button')) return
                    var post_id = $(e.target).closest('div.row.hover-accent').attr('data-id')
                    var post_slug = $(e.target).closest('div.row.hover-accent').attr('data-slug')
                    window.location.href = '/d/' + post_id + '-' + post_slug
                    break
                case 'quotePost':
                    var editor = $(".sucresBB-editor")
                    var str = $(editor).val()
                    $(editor).val(str + '#p:' + $(e.target).closest('a').attr('data-id') + ' ')
                    break
                case 'openPreview':
                    e.preventDefault()
                    preview_action()
                    break
                case 'openRisibank':
                    risibank.init()
                    break
                case 'insertRisibank':
                    let src = $(e.target).closest('a').attr('data-src')

                    var editor = $(".sucresBB-editor")
                    var str = $(editor).val()
                    $(editor).val(str + "[img]" + src + "[/img]")
                    $("#risibank").modal('hide')

                    break
                case 'openNoelshack':
                    noelshack.init()
                    break
                case 'openImgur':
                    imgur.init()
                    break
            }
        })
    })
}

var preview_action = function () {
    var editor = $(".sucresBB-editor")
    var str = $(editor).val()
    $("#preview-dom").html('<div class="my-5 text-center"><i class="fas fa-sync fa-spin fa-1x"></i></div>')

    $.ajax({
        type: 'POST',
        url: '/d/preview',
        data: {
            '_token': csrf_token,
            'body': str,
        },
        success: function (resp) {
            $("#preview-dom").html('<div class="post-content">' + resp.render + '</div>')
        },
        error: function () {
            $("#preview-dom").html('<div class="my-5 text-center"><i class="fas fa-exclamation-circle text-danger fa-1x"></i></div>')
        }
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
        var $popular = $("#risibank-popular")
        var $latest = $("#risibank-latest")
        var $random = $("#risibank-random")
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
        var $search = $("#risibank-search")
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
                        noelshack.setProgress(Math.round(percentComplete * 100))
                    }
                }, false)
                return xhr
            },
            success: function (resp) {
                var regex = /(?:https:\/\/www\.noelshack\.com\/)(\d{4})-(\d{2})-(\d*)-(.*)$/gs;
                var results = regex.exec(resp)
                // console.log(results);
                if (results != null) {
                    var editor = $(".sucresBB-editor")
                    var str = $(editor).val()
                    $(editor).val(str + "[url=" + resp + "][img]https://image.noelshack.com/fichiers/" + results[1] + "/" + results[2] + "/" + results[3] + "/" + results[4] + "[/img][/url]")
                    $("#noelshack").modal('hide')
                } else {
                    noelshack.setError(resp)
                    noelshack.setForm()
                }
            },
            error: function (resp) {
                noelshack.setError(resp)
            },
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
    clearError: function () {
        $('#noelshack-error').hide()
        $('#noelshack-error').empty()
    },
    hideAll: function () {
        $('#noelshack-progress').hide()
        $('#noelshack-form').hide()
    }
};

let imgur = {
    init: function () {
        $("#imgur-uploadaction").off('click')
        $("#imgur-uploadaction").click(function (e) {
            e.preventDefault()
            imgur.upload()
        })
        imgur.clearError()
        imgur.setForm()
    },
    upload: function () {
        imgur.clearError()
        imgur.setProgress(0)

        var formData = new FormData();
        formData.append('file', $("#imgur-uploadinput")[0].files[0])

        $.ajax({
            type: 'POST',
            url: "/api/v0/imgur-gateway/upload",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        imgur.setProgress(Math.round(percentComplete * 100))
                    }
                }, false)
                return xhr
            },
            success: function (resp) {
                // console.log(resp)
                if (resp.success) {
                    var editor = $(".sucresBB-editor")
                    var str = $(editor).val()
                    $(editor).val(str + "[img]" + resp.file.link + "[/img]")
                    $("#imgur").modal('hide')
                } else {
                    imgur.setError(resp.error)
                    imgur.setForm()
                }
            },
            error: function (e) {
                var resp = e.responseJSON;
                imgur.setError(resp.errors.file[0])
                imgur.setForm()
            },
        })
    },
    setForm: function () {
        imgur.hideAll()
        $('#imgur-form').show()
        $('#imgur-upload').show()
        $('#imgur-uploadinput').val('')
    },
    setProgress: function (percent) {
        imgur.hideAll()
        $('#imgur-progress').show()
        percent = '<i class="fas fa-sync fa-spin fa-1x mr-1 mb-2"></i><br>' + percent + "%";
        $('#imgur-progress').html(percent)
    },
    setError: function (str) {
        $('#imgur-error').show()
        str = '<i class="fas fa-exclamation-circle fa-1x mr-1"></i>' + str;
        $('#imgur-error').html(str)
    },
    clearError: function () {
        $('#imgur-error').hide()
        $('#imgur-error').empty()
    },
    hideAll: function () {
        $('#imgur-progress').hide()
        $('#imgur-form').hide()
    }
};

$(document).ready(function () {
    init_spoilers()
    init_baffle()
    init_actions()
    init_select2();

    autocomplete.init();
    bsCustomFileInput.init()
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    })
    $('[data-toggle="fancybox"]').fancybox({})

    if (location.hash && $(location.hash)) {
        scrollTo($(location.hash));
        if (location.hash.substr(0, 1) == 'p') highlight($(location.hash));
    }
    if (window.fourSucres.hasNotifications) setAltFavicon()

    $('form.disable-on-submit').submit(function (e) {
        console.log($(this));
        $(this).find('button').attr('disabled', true);
    });
})

function getInputSelection(elem) {
    if (typeof elem != "undefined") {
        var s = elem[0].selectionStart;
        var e = elem[0].selectionEnd;
        return elem.val().substring(s, e)
    } else {
        return '';
    }
}

function scrollTo(target) {
    if (target.length) {
        $("html, body").stop().animate({
            scrollTop: target.offset().top - 100
        }, 250);
    }
}

$("a[href*='#']:not([href='#'])").click(function () {
    if (
        location.hostname == this.hostname &&
        this.pathname.replace(/^\//, "") == location.pathname.replace(/^\//, "")
    ) {
        var anchor = $(this.hash);
        anchor = anchor.length ? anchor : $("[name=" + this.hash.slice(1) + "]");
        scrollTo(anchor);
        highlight(anchor);
    }
});

function highlight(target) {
    let count = 0,
        max = 3;
    let highlight = setInterval(() => {
        $(target).toggleClass('op-8');
        if (count++ >= max) {
            clearInterval(highlight);
        }
    }, 300);
}

function setAltFavicon() {
    $('link[rel="icon"]').each((k, el) => {
        var $el = $(el)
        $el.attr('href', '/img/icons/favicon-' + $el.attr('sizes') + '-alt.png');
    })
}
