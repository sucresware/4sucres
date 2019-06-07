import $ from 'jquery';
import Baffle from 'baffle';
import WOW from 'wowjs';

const DefaultOptions = {
    characters: ["█", "▓", "▒", "░", "█", "▓", "▒", "░", "█", "▓", "▒", "░", "<", ">", "/"],
    selector: 'baffle',
    revealDuration: 1000
};

/**
 * Gère la fonctionnalité d'obfuscation des messages.
 */
class BaffleWrapper {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };
        this.baffleOptions = {
            characters: this.options.characters
        };

        $(document).ready(() => this.baffle());
    }

    baffle() {
        let that = this;

        new WOW.WOW({
            animateClass: this.options.selector,
            callback: function (box) {
                Baffle(box, that.baffleOptions).reveal(that.options.revealDuration);
            },
        }).init();
    }
}

export default new BaffleWrapper(DefaultOptions);
