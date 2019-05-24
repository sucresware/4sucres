import Pusher from 'pusher-js';
import LaravelEcho from "laravel-echo";

const DefaultOptions = {
    broadcaster: 'pusher',
    key: '',
    cluster: '',
};

class EchoWrapper {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };

        this.options.key = process.env.MIX_PUSHER_APP_KEY;
        this.options.cluster = process.env.MIX_PUSHER_APP_CLUSTER;

        if (process.env.NODE_ENV === 'development') {
            Pusher.logToConsole = true;
        }

        this.register()
    }

    register() {
        this.echo = new LaravelEcho({
            broadcaster: this.options.broadcaster,
            key: this.options.key,
            cluster: this.options.cluster,
            // wsHost: window.location.hostname,
            // wsPort: 2053,
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
