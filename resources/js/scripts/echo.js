import Pusher from 'pusher-js';
import LaravelEcho from "laravel-echo";

const DefaultOptions = {
    broadcaster: 'pusher',
    key: '',
};

class EchoWrapper {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };

        this.options.key = process.env.MIX_PUSHER_APP_KEY;

        if (process.env.NODE_ENV === 'development') {
            Pusher.logToConsole = true;
        }

        this.register()
    }

    register() {
        this.echo = new LaravelEcho({
            broadcaster: this.options.broadcaster,
            key: this.options.key,
            wsHost: window.location.hostname,
            wsPort: 2053,
            disableStats: true,
        });
    }
}

const Echo = new EchoWrapper(DefaultOptions);

export default Echo;
export {
    Echo,
    Pusher
};
