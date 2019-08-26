import $ from 'jquery';

const DefaultOptions = {
    selector: '.spoiler',
    revealClass: 'show'
};

/**
 * Gère la fonctionnalité de spoilers des messages.
 */
class SpoilerLoader {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };
        $(document).ready(() => this.initialize());
    }

    initialize() {
        $(this.options.selector).on('click', (e) => {
            $(e.target).addClass(this.options.revealClass);
        });
    }
}

export default new SpoilerLoader(DefaultOptions);
