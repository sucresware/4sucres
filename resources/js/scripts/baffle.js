import $ from 'jquery';
import Baffle from 'baffle';

const DefaultOptions = {
    characters: ["█", "▓", "▒", "░", "█", "▓", "▒", "░", "█", "▓", "▒", "░", "<", ">", "/"],
    selector: '.baffle',
    revealDuration: 1000
};

/**
 * Gère la fonctionnalité d'obfuscation des messages.
 */
class BaffleWrapper {

    constructor(options) {
        this.options = { ...DefaultOptions, ...options };
        this.baffleOptions = {
            characters: this.options.characters
        };
        
        $(document).ready(() => this.baffle());
    }

    baffle() {
        Baffle(this.options.selector, this.baffleOptions).reveal(this.options.revealDuration);
    }
}

export default new BaffleWrapper(DefaultOptions);