import iziToast from 'izitoast'

// TODO - CSS
// box-shadow: 2px 2px 20px 0px #0000007d;

const DefaultOptions = {
    toastPosition: 'topRight',
    toastTimeout: 5000
}

/**
 * Gère le chargement des fonctionnalités relatives aux notifications contextuelles.
 */
class ToastWrapper {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };

        iziToast.settings({
            position: this.options.toastPosition
        });
    }

    notify(content, title, type) {
        type = this.getType(type);
        let options = {
            content: content,
            timeout: this.options.toastTimeout
        };

        if (title !== undefined && title !== null) {
            options.title = title;
        }

        return this.fullToast(options, type);
    }

    create(options, type) {
        type = this.getType(type);

        return iziToast[type]({
            ...{
                timeout: this.options.toastTimeout
            },
            ...options
        });
    }

    getType(type) {
        switch (type) {
            case 'danger':
            case 'error':
                return 'error';

            case 'success':
                return 'success';

            case 'warn':
            case 'warning':
                return 'warning';

            case 'info':
            default:
                return 'info';
        }
    }
}

var Toast = new ToastWrapper(DefaultOptions);
export default Toast;
export {
    Toast
};
