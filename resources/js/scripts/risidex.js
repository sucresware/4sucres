import $ from 'jquery';

const DefaultOptions = {
    api: {
        baseURL: 'https://cors-anywhere.herokuapp.com/https://api.onche.party/',
        top: 'top',
        recent: 'recent',
        trending: 'trending',
        random: 'random',
        search: 'search?q=%query%'
    },
    modalSelector: '#risidex',
    searchFieldSelector: '#risidex-searchfield',
    tabs: {
        top: '#risidex-top',
        recent: '#risidex-recent',
        trending: '#risidex-trending',
        random: '#risidex-random',
        search: '#risidex-search'
    },
    loadTemplate: '<div class="my-5"><i class="fas fa-sync fa-spin fa-1x"></i></div>',
    errorTemplate: '<div class="my-5"><i class="fas fa-exclamation-circle text-danger fa-1x"></i></div>',
    noresultTemplate: '<div class="my-5"><i class="fas fa-exclamation-circle text-warning fa-1x"></i></div>',
};

class RisidexWrapper {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };

        $(document).ready(() => this.initialize());
    }

    initialize() {
        $(this.options.modalSelector).on('show.bs.modal', () => {
            if (!this.loaded) {
                this.load();
            }
        });
    }

    async load() {
        this.setLoading(this.options.tabs.top)
        this.setLoading(this.options.tabs.recent)
        this.setLoading(this.options.tabs.trending)
        this.setLoading(this.options.tabs.random)

        try {
            let top = await $.getJSON(this.options.api.baseURL + this.options.api.top);
            this.setStickers(this.options.tabs.top, top)

            let recent = await $.getJSON(this.options.api.baseURL + this.options.api.recent);
            this.setStickers(this.options.tabs.recent, recent)

            let trending = await $.getJSON(this.options.api.baseURL + this.options.api.trending);
            this.setStickers(this.options.tabs.trending, trending)

            let random = await $.getJSON(this.options.api.baseURL + this.options.api.random);
            this.setStickers(this.options.tabs.random, random)
        } catch (error) {
            this.setError(this.options.tabs.top)
            this.setError(this.options.tabs.recent)
            this.setError(this.options.tabs.trending)
            this.setError(this.options.tabs.random)
        }

        this.loaded = true;
    }

    setLoading(selector) {
        $(selector).empty();
        $(selector).html(this.options.loadTemplate);

        return this;
    }

    setError(selector, noResult) {
        $(selector).empty();
        $(selector).html(noResult === true ? this.options.noresultTemplate : this.options.errorTemplate);

        return this;
    }

    setStickers(selector, stickers) {
        $(selector).empty();

        if (stickers.length == 0) {
            this.setError(this.options.tabs.search, true);
            return this;
        }

        $.each(stickers, (i, sticker) => {
            $(selector).append(this.getStickerTemplate(sticker.image));
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
            url: this.options.api.baseURL + _url,
            success: (resp) => {
                this.setStickers(this.options.tabs.search, resp);
            },
            error: () => {
                this.setError(this.options.tabs.search);
            }
        });

        return this;
    }
}

const Risidex = new RisidexWrapper(DefaultOptions);
export default Risidex;
export {
    Risidex
};
