import $ from 'jquery';
import v from 'voca';
import Editor from './editor.js';
import Risibank from './risibank.js';
import Imgur from './imgur.js';

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

    onImgurUpload() {
        Imgur.upload();
    }

    onInsertSticker(element) {
        let output = ` ${element.data('src')} `;

        Editor.insert(output);

        // TODO - Maybe remove?
        Risibank.close();
    }

    onRisibankSearch(element, event) {
        event.preventDefault();
        Risibank.search();
    }

    onOpenPreview(element, event) {
        event.preventDefault();
        $("#preview-dom").html('<div class="my-5 text-center"><i class="fas fa-sync fa-spin fa-1x"></i></div>')
    
        $.ajax({
            type: 'POST',
            url: route(PREVIEW_ROUTE).url(),
            data: {
                '_token': $('meta[name=csrf-token]').attr('content'),
                'body': Editor.editor.value(),
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
            quote = `#p:${postId}\r\n\r\n`,
            codeMirror = Editor.getCodeMirror(),
            selectionEnd = codeMirror.getCursor('end');

        codeMirror.setSelection(selectionEnd, selectionEnd);
        codeMirror.replaceSelection(quote);
        codeMirror.focus();
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
        
        if (window.event.ctrlKey) {
            window.open(url, '_blank').focus();
        } else {
        window.location.href = url;
    }
}
}

export default new ActionHandler();
