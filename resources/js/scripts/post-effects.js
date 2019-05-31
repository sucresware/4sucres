import $ from 'jquery';

const DefaultOptions = {
    scrollOffset: 100,
    scrollDuration: 300,
    highlight: {
        flashCount: 4,
        class: 'highlight',
        flashDuration: 175
    }
}

/**
 * Gère les effets visuels et la qualité de vie relatifs aux posts.
 */
class PostEffects {

    constructor(options) {
        this.options = { ...DefaultOptions, ...options };
        $(document).ready(() => this.initialize());
    }

    initialize() {
        this.hash = location.hash;

        if (this.hash) {
            this.scrollTo();

            if (this.hash.substr(1, 1) == 'p') {
                this.highlight();
            }
        }

        this.handleLinkClick();
    }

    handleLinkClick() {
        let that = this;

        $('a[href^="#p"]').click(function(e) { // Fix #16
            if (location.hostname === this.hostname
                && this.pathname.replace(/^\//, "") === location.pathname.replace(/^\//, "")
            ) {
                let target = $(that.hash).length ? $(that.hash) : $("[name=" + that.hash.slice(1) + "]");
                that.scrollTo(target);
                that.highlight(target);
            }
        });
    }

    scrollTo(hash) {
        let target = undefined !== hash ? hash : $(this.hash);

        if (!target.length) {
            console.warn('There is no hash to scroll to.');
            return;
        }

        $('html, body')
            .stop()
            .animate({
                scrollTop: target.offset().top - this.options.scrollOffset
            }, this.options.scrollDuration);
    }

    highlight(hash) {
        let target = undefined !== hash ? hash : $(this.hash);

        if (!target.length) {
            console.warn('There is no hash to highlight.');
            return;
        }

        let count = 0,
            max = this.options.highlight.flashCount;

        let highlight = setInterval(() => {
            target.toggleClass(this.options.highlight.class);
            if (count++ >= max) {
                clearInterval(highlight);
            }
        }, this.options.highlight.flashDuration);
    }

}

export default new PostEffects(DefaultOptions);