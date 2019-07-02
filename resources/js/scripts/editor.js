import $ from 'jquery';
let {
    Textcomplete,
    Textarea
} = require('textcomplete');

let userMeta = $('meta[name=user-data]');
let user;

if (userMeta.length) {
    user = JSON.parse(userMeta.attr('content'));
}

const DefaultOptions = {
    editor: {
        selector: 'textarea#body',
    },
    userAutocomplete: {
        regex: /(@|#u:)([\w\d-]+)$/,
        fetchUrl: route('api.users.all').url(),
        dropdownTemplate: '%user%',
        outputTemplate: '@%user% '
    },
    emojiAutocomplete: {
        regex: /(:)([\w\d-]+)$/,
        fetchUrl: user ? route('api.users.emojis', [user.id]).url() : null,
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
        let $el = $(this.options.editor.selector);
        if (!$el) return;

        $el.on('focus', () => this.initializeAutocomplete());
    }

    initializeAutocomplete() {
        this.loadUsers().then(() => this.loadEmojis().then(() => this.registerAutocomplete()));
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
            if (!user) {
                reject();
            }

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

    registerAutocomplete() {
        let that = this;
        let _editor = new Textarea($(this.options.editor.selector)[0]);

        this.autoComplete = new Textcomplete(_editor);
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

        this.autoComplete.register([{
            // Matches :<name>:
            match: this.options.emojiAutocomplete.regex,

            // Calls callback with the search values thanks to search terms
            search: function (term, callback) {
                callback(that.applyEmojiAutocompleteFilter(':' + term));
            },

            // The way it's rendered in the dropdown
            template: function (emoji) {
                switch (emoji.type) {
                    case 'discord':
                        return '<div class="emoji emoji-sm" style="background-image: url(' + emoji.link + '"></div> ' + emoji.shortname;
                    case 'smiley':
                        return '<img src="' + emoji.link + '"> ' + emoji.shortname;
                    case 'emoji':
                        return emoji.html + ' ' + emoji.shortname;
                    default:
                        return emoji.shortname;
                }
            },

            // The output when user selects in the dropdown
            replace: function (emoji) {
                return emoji.shortname;
            }
        }])
    }

    applyAutocompleteFilter(term) {
        return $.grep(this.autocompleteUsers, user => {
            return user.toLowerCase().includes(term.toLowerCase());
        });
    }

    applyEmojiAutocompleteFilter(term) {
        return $.grep(this.autocompleteEmojis, emoji => {
            return emoji.shortname.toLowerCase().includes(term.toLowerCase());
        });
    }

    insert(value) {
        let $el = $(this.options.editor.selector),
            el = $el[0];
        if (!$el) return;

        var caretPos = el.selectionStart;
        var textAreaTxt = el.value;
        el.value = textAreaTxt.substring(0, caretPos) + value + textAreaTxt.substring(caretPos);

        $el.focus();
    }
}

var Editor = new EditorWrapper(DefaultOptions);

export default Editor;
export {
    Editor
};
