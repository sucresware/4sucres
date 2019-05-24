import $ from 'jquery';

const DefaultOptions = {
    api: {
        load: 'https://api.risibank.fr/api/v0/load',
        search: 'https://api.risibank.fr/api/v0/search?search=%query%'
    },
    modalSelector: '#risibank',
    searchFieldSelector: '#risibank-searchfield',
    tabs: {
        popular: '#risibank-popular',
        latest:  '#risibank-latest',
        random:  '#risibank-random',
        search:  '#risibank-search'
    },
    loadTemplate: '<div class="my-5"><i class="fas fa-sync fa-spin fa-1x"></i></div>',
    errorTemplate: '<div class="my-5"><i class="fas fa-exclamation-circle text-danger fa-1x"></i></div>',
    noresultTemplate: '<div class="my-5"><i class="fas fa-exclamation-circle text-warning fa-1x"></i></div>',
};

class RisibankWrapper {

    constructor(options) {
        this.options = { ...DefaultOptions, ...options };

        $(document).ready(() => this.initialize());
    }

    initialize() {
        $(this.options.modalSelector).on('show.bs.modal', () => {
            if (!this.loaded) {
                this.load();
            }
        });
    }

    load() {
        this.setLoading(this.options.tabs.popular);
        this.setLoading(this.options.tabs.latest);
        this.setLoading(this.options.tabs.random);

        $.getJSON('https://cors-anywhere.herokuapp.com/' + this.options.api.load)
            .done((resp) => {
                this.setStickers(this.options.tabs.popular, resp.stickers.views)
                this.setStickers(this.options.tabs.latest, resp.stickers.tms)
                this.setStickers(this.options.tabs.random, resp.stickers.random)
            })
            .fail(() => {
                this.setError(this.options.tabs.popular)
                this.setError(this.options.tabs.latest)
                this.setError(this.options.tabs.random)
            });

        this.loaded = true;
    }

    setLoading(selector) {
        $(selector).empty();
        $(selector).html(this.options.loadTemplate);

        return this;
    }

    setError(selector, noResult) {
        $(selector).empty();
        $(selector).html(noResult === true ? this.options.noresultTemplate: this.options.errorTemplate);

        return this;
    }

    setStickers(selector, stickers) {
        $(selector).empty();

        if (stickers.length == 0) {
            this.setError(this.options.tabs.search, true);
            return this;
        }

        $.each(stickers, (i, sticker) => {
            $(selector).append(this.getStickerTemplate(sticker.risibank_link));
        });

        return this;
    }

    registerKeypress() {
        $(searchFieldSelector).keypress((e) => {
            var keycode = (e.keyCode ? e.keyCode : e.which)
            if (keycode == '13') {
                e.preventDefault()
                this.search()
            }
        });

        return this;
    }

    // TODO : Vue
    getStickerTemplate(link) {
        let template = `
            <span class="pointer"
                data-action="insert-sticker"
                data-src="%link%">
                <img src="%link%"
                    class="img-thumbnail sticker">
            </span>`;

        return template
            .replace(/(%link%)/g, link)
            .trim();
    }

    open() {
        return $(this.options.modalSelector).modal();
    }

    close() {
        return $(this.options.modalSelector).modal('hide');
    }

    search(value) {
        this.setLoading(this.options.tabs.search);

        let _search = value || $(this.options.searchFieldSelector).val(),
            _url = this.options.api.search.replace(/(%query%)/g, _search);

        $.ajax({
            type: 'POST',
            url: 'https://cors-anywhere.herokuapp.com/' + _url,
            success: (resp) => {
                this.setStickers(this.options.tabs.search, resp.stickers);
            },
            error: () => {
                this.setError(this.options.tabs.search);
            }
        });

        return this;
    }
}

const Risibank = new RisibankWrapper(DefaultOptions);
export default Risibank;
export { Risibank };