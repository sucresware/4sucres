import $ from 'jquery';

// Explanation needed. Why the fuck should I have to do this?
global.jQuery = require('jquery');
require('@fancyapps/fancybox/dist/jquery.fancybox.min.js');

/**
 * Handle lightboxes on images.
 */
class LightboxWrapper {

    constructor() {
        $(document).ready(() => this.initialize());
    }

    initialize() {
        $('[data-toggle=lightbox]').fancybox({})
    }
}

export default new LightboxWrapper();