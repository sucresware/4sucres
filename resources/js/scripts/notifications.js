import $ from 'jquery';
import Echo from './echo';
import Howl from './howl';
import Toast from './toasts.js';

const DefaultOptions = {
    privateMessageNotificationSelector: '#private_discussions_indicator',
    genericNotificationSelector: '#notifications_indicator',
    notificationMarkup: `<i class="fas fa-circle fa-stack-2x text-primary"></i>` +
        `<i class="fas %icon% fa-stack-1x fa-inverse"></i>` +
        `<span class="badge badge-danger badge-pill badge-notification">%count%</span>`,
    normalFavicon: '/img/icons/favicon.ico',
    notificationFavicon: '/img/icons/favicon-alt.ico',
};

const NotificationTypes = {
    NEW_PRIVATE_DISCUSSION: 'App\\Notifications\\NewPrivateDiscussion',
    NEW_MENTION: 'App\\QuotedInPost\\QuotedInPost',
    NEW_REPLY: 'App\\Notifications\\ReplyInDiscussion'
}

class NotificationHandler {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };

        this.initialize();
        this.register();
    }

    initialize() {
        let userMeta = $('meta[name=user-data]'),
            notificationMeta = $('meta[name=user-notification-count]');

        if (userMeta.length) {
            this.user = JSON.parse(userMeta.attr('content'));
            this.notificationCount = JSON.parse(notificationMeta.attr('content'));
        }

        this.notificationPlayer = Howl.notificationPlayer;
        this.initialized = true;
    }

    updateFavicon() {
        // TODO - sized favicons.
        // Needs a favicon for each size.
        let faviconMetas = ['shortcut icon', 'apple-touch-icon-precomposed', 'icon'];
        $.each(faviconMetas, (i, e) => {
            $(`link[rel='${e}']`).attr('href', this.options.notificationFavicon);
        });
    }

    playNotificationSound() {
        if (!this.initialized) {
            console.debug('Tried to play a notification sound without it being initialized.');
            return;
        }

        this.notificationPlayer.play();
    }

    notifyUser(notification) {
        Toast.create({
            title: notification.title,
            message: notification.html,
            buttons: [
                ['<button>Voir</button>', function (instance, toast) {
                    window.location.href = notification.url
                }],
            ],
            balloon: 1,
            layout: 2,
            icon: 'fas fa-asterisk',
            iconColor: '#D08770',
            backgroundColor: '#fff',
            maxWidth: '400px'
        }, 'success');
    }

    updateHtml(notification) {
        let isPrivate = notification.type == NotificationTypes.NEW_PRIVATE_DISCUSSION ||
            (notification.type == NotificationTypes.NEW_REPLY &&
                notification.private);

        let getMarkup = (icon) => {
            return String(this.options.notificationMarkup)
                .replace('%icon%', icon)
                .replace('%count%', '&bullet;');
        };

        $(this.options.genericNotificationSelector)
            .html(getMarkup('fa-bell'));

        if (isPrivate) {
            $(this.options.privateMessageNotificationSelector)
                .html(getMarkup('fa-envelope'));
        }

    }

    register() {
        let user = this.getUser();

        if (!user) {
            return;
        }

        Echo.echo.private(`App.Models.User.${user.id}`)
            .notification((notification) => {
                this.notifyUser(notification);
                this.updateHtml(notification);
                this.playNotificationSound();
                this.updateFavicon();
            });

        $(document).ready(() => {
            if (this.getNotificationCount() > 0) {
                this.updateFavicon();
            }
        });
    }

    getUser() {
        if (!this.initialized) {
            this.initialize();
        }

        return this.user;
    }

    getNotificationCount() {
        if (!this.initialized) {
            this.initialize();
        }

        return this.notificationCount;
    }

}

export default new NotificationHandler(DefaultOptions);
