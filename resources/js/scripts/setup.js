import $ from 'jquery';
import CustomFileInput from 'bs-custom-file-input'
import HighlightJS from 'highlightjs';

global.jQuery = require('jquery');
require('owl.carousel');

/**
 * Gère le chargement de diverses fonctionnalités.
 */
class Setup {

    constructor() {
        $(document).ready(() => this.initialize());
    }

    initialize() {
        CustomFileInput.init();
        this.initializeSelect2();
        this.initializeTooltips();
        this.initializeAjax();
        this.initializeHighlightJS();
        this.initializeOwl();
    }

    initializeSelect2() {
        $('select:visible').select2({
            theme: 'bootstrap4',
        });
    }

    initializeTooltips() {
        $('[data-toggle="tooltip"]').tooltip({
            container: 'body'
        });
    }

    initializeAjax() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
            }
        });
    }

    initializeHighlightJS() {
        HighlightJS.initHighlightingOnLoad();
    }

    initializeForms() {
        $('[data-disable-on-submit]').submit(function (e) {
            $(this).find('button').attr('disabled', true);
        });
    }

    initializeOwl() {
        $(".owl-carousel").owlCarousel({
            autoplay: true,
            autoplaySpeed: 500,
            loop: true,
            items: 1
        });
    }
}

export default new Setup();
