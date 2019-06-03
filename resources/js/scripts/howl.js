import {
    Howl,
    Howler
} from 'howler';

const DefaultOptions = {
    notificationSound: ['/audio/intuition.mp3'],
    notificationVolume: .4, // TODO - User option?
    lightTogglerSound: ['/audio/tink.mp3'],
    lightTogglerVolume: .6,
};

class HowlWrapper {

    constructor(options) {
        this.options = {
            ...DefaultOptions,
            ...options
        };

        this.notificationPlayer = new Howl({
            src: this.options.notificationSound,
            volume: this.options.notificationVolume,
            html5: true,
            onloaderror: () => {
                console.warn('Could not load notification sound.')
            }
        });

        this.lightTogglerPlayer = new Howl({
            src: this.options.lightTogglerSound,
            volume: this.options.lightTogglerVolume,
            html5: true,
            onloaderror: () => {
                console.warn('Could not load light toggler sound.')
            }
        });
    }
}

const Player = new HowlWrapper(DefaultOptions);

export default Player;
export {
    Player
};
