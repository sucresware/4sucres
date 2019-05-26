import $ from 'jquery';
import EasyMDE from 'easymde'
import AutoComplete from 'textcomplete/lib/textcomplete';
import CodeMirrorEditor from 'textcomplete.codemirror';

const DefaultOptions = {
    editor: {
        selector: 'textarea.sucresMD-editor',
        insertTexts: {
            horizontalRule: [
                "",
                "\n\n---\n\n"
            ],
            table: [
                "",
                "\n| Colonne 1 | Colonne 2 | Colonne 3 |\n| -------- | -------- | -------- |\n| Texte    | Texte     | Texte    |\n"
            ],
        },
        toolbar: [
            'bold',
            'italic',
            'strikethrough',
            '|',
            'code',
            'unordered-list',
            'ordered-list',
            '|',
            'link',
            'image',
            'table',
            'horizontal-rule',
            '|',
            'guide',
        ],
    },
    userAutocomplete: {
        regex: /(@|#u:)([\w\d-]+)$/,
        fetchUrl: route('api.users.all').url(),
        dropdownTemplate: '%user%',
        outputTemplate: '@%user% '
    },
    emojiAutocomplete: {
        regex: /(:)([\w\d-]+)$/,
        fetchUrl: route('api.emojis.all').url(),
        dropdownTemplate: '<img src="%emojiLink%" width="20px"> :%emoji%:',
        outputTemplate: ':%emoji%: '
    },
}

/**
 * Gère les effets visuels et la qualité de vie relatifs aux posts.
 */
class EditorWrapper {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };
        $(document).ready(() => this.initialize());
    }

    initialize() {
        let element = $(this.options.editor.selector)[0];

        if (!element) {
            return;
        }

        this.editor = new EasyMDE({
            element: element,
            forceSync: true,
            promptURLs: true,
            spellChecker: false,
            autoDownloadFontAwesome: false,
            status: false,
            tabSize: 4,
            insertTexts: this.options.editor.insertTexts,
            renderingConfig: {
                codeSyntaxHighlighting: true,
            },
            toolbar: this.options.editor.toolbar
        });

        this.registerCustomCodes();

        this.getCodeMirror().on('focus', () => {
            this.initializeAutocomplete();
        });
    }

    initializeAutocomplete() {
        this.loadUsers().then(() => this.registerUserAutocomplete());
        this.loadEmojis().then(() => this.registerEmojiAutocomplete());
    }

    loadUsers() {
        return new Promise((resolve, reject) => {
            $.get(this.options.userAutocomplete.fetchUrl)
                .then(result => {
                    this.autocompleteUsers = result;
                    resolve();
                })
                .fail(() => {
                    reject();
                });
        });
    }

    loadEmojis() {
        return new Promise((resolve, reject) => {
            $.get(this.options.emojiAutocomplete.fetchUrl)
                .then(result => {
                    this.autocompleteEmojis = result;
                    resolve();
                })
                .fail(() => {
                    reject();
                });
        });
    }

    registerUserAutocomplete() {
        let that = this;
        this.autoComplete = new AutoComplete(new CodeMirrorEditor(this.getCodeMirror()));
        this.autoComplete.register([{
            // Matches @<username> or #u:<id>
            match: this.options.userAutocomplete.regex,

            // Calls callback with the search values thanks to search terms
            search: function (term, callback) {
                callback(that.applyAutocompleteFilter(term));
            },

            // The way it's rendered in the dropdown
            template: function (user) {
                return that.options.userAutocomplete.dropdownTemplate.replace('%user%', user);
            },

            // The output when user selects in the dropdown
            replace: function (user) {
                return that.options.userAutocomplete.outputTemplate.replace('%user%', user);
            }
        }])
    }

    registerEmojiAutocomplete() {
        let that = this;
        this.emojiAutoComplete = new AutoComplete(new CodeMirrorEditor(this.getCodeMirror()));
        this.emojiAutoComplete.register([{
            // Matches :<name>:
            match: this.options.emojiAutocomplete.regex,

            // Calls callback with the search values thanks to search terms
            search: function (term, callback) {
                callback(that.applyEmojiAutocompleteFilter(term));
            },

            // The way it's rendered in the dropdown
            template: function (emoji) {
                return that.options.emojiAutocomplete.dropdownTemplate.replace('%emoji%', emoji.name).replace('%emojiLink%', emoji.link);
            },

            // The output when user selects in the dropdown
            replace: function (emoji) {
                return that.options.emojiAutocomplete.outputTemplate.replace('%emoji%', emoji.name);
            }
        }])
    }

    applyAutocompleteFilter(term) {
        return $.grep(this.autocompleteUsers, user => {
            return user.toLowerCase().startsWith(term.toLowerCase());
        });
    }

    applyEmojiAutocompleteFilter(term) {
        return $.grep(this.autocompleteEmojis, emoji => {
            return emoji.name.toLowerCase().startsWith(term.toLowerCase());
        });
    }

    getCodeMirror() {
        if (undefined !== this.editor && undefined !== this.editor.codemirror) {
            return this.editor.codemirror;
        }

        return null;
    }

    insert(value, end = false) {
        let codeMirror = this.getCodeMirror(),
            position = end ? codeMirror.getCursor('to') : codeMirror.getCursor() || codeMirror.getCursor('to');

        codeMirror.replaceRange(value, position)
    }

    registerCustomCodes() {
        let that = this;

        $(document).on('click', "[data-mdcode]", function () {
            let codeMirror = that.getCodeMirror(),
                originalPoint = codeMirror.getCursor('start'),
                character = $(this).data('mdcode'),
                replacement = `${character}${codeMirror.getSelection()}${character}`;

            codeMirror.replaceSelection(replacement);

            originalPoint = {
                ...originalPoint,
                ...originalPoint.ch += replacement.length - character.length
            };
            codeMirror.setSelection(originalPoint, originalPoint);
            codeMirror.focus();
        });
    }

}

var Editor = new EditorWrapper(DefaultOptions);

export default Editor;
export {
    Editor
};
