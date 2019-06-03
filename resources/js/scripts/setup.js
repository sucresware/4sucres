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
        this.applyDarkMode();
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

    applyDarkMode() {
        var darkMode = localStorage.getItem('darkMode');

        if (darkMode === "on") {
            document.getElementById('darkTheme').disabled = false;
        } else {
            document.getElementById('darkTheme').disabled = true;
        }
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
            autoplayTimeout: 10000,
            loop: true,
            items: 1
        });
    }
}

export default new Setup();
