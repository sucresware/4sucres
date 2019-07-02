import $ from 'jquery';
import v from 'voca';
import Imgur from './imgur.js';
import Howl from './howl';
import AuthedAxios from "../scripts/axios";
import Editor from './editor';

const EDITOR = "textarea#body";
const ON_OPEN_DISCUSSION_ROUTE = 'discussions.show';
const PREVIEW_ROUTE = 'discussions.preview';

/**
 * Gère le chargement des actions.
 * Une action est définie par un attribut `data-action` dont la valeur
 * est sous la forme `action-name` et dont la fonction associée est sous
 * la forme `onActionName`.
 */
class ActionHandler {

    constructor() {
        $(document).ready(() => this.initialize());
    }

    initialize() {
        let that = this;
        $(document).on('click', '[data-action]', function (event) {
            let element = $(this),
                actionData = element.data('action'),
                actionName = `on${v.capitalize(v.camelCase(actionData))}`;

            if (typeof that[actionName] !== 'function') {
                console.log(`${actionName} is not a valid action.`);
                return;
            }

            that[actionName](element, event);
        });
    }

    async onLightToggle() {
        var lightMode = document.getElementById('darkTheme').disabled;

        document.getElementById('darkTheme').disabled = !lightMode;
        AuthedAxios.get("light-toggler");
        Howl.lightTogglerPlayer.play();
    }

    onOpenPreview(element, event) {
        event.preventDefault();
        $("#preview-dom").html('<div class="my-5 text-center"><i class="fas fa-sync fa-spin fa-1x"></i></div>')

        $.ajax({
            type: 'POST',
            url: route(PREVIEW_ROUTE).url(),
            data: {
                '_token': $('meta[name=csrf-token]').attr('content'),
                'body': $(EDITOR).val(),
            },
            success: function (resp) {
                $("#preview-dom").html('<div class="post-content">' + resp.render + '</div>')
            },
            error: function () {
                $("#preview-dom").html('<div class="my-5 text-center"><i class="fas fa-exclamation-circle text-danger fa-1x"></i></div>')
            }
        })
    }

    onQuotePost(element) {
        let postId = $(element).data('id'),
            quote = `#p:${postId}\r\n\r\n`;

        Editor.insert(quote);
    }

    onOpenDiscussion(element) {
        let id = element.data('id') || undefined,
            slug = element.data('slug') || undefined,
            url = route(ON_OPEN_DISCUSSION_ROUTE, {
                id,
                slug
            }).url();

        if (undefined === id || undefined === slug) {
            console.log('There is no destination for this URL.');
        }

        let last = (window.event.altKey) ? '?page=last' : '';

        if (window.event.ctrlKey) {
            window.open(url + last, '_blank').focus();
        } else {
            window.location.href = url + last;
        }
    }
}

export default new ActionHandler();
