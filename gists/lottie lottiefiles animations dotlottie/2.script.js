// npm install @dotlottie/player-component
import '@dotlottie/player-component';

export default class Page {
    constructor() {
        this.player = null;
        this.playing = false;
        this.queue = [];
    }

    async ready() {}

    async load() {
        document.querySelectorAll('button').forEach($button => {
            $button.addEventListener('click', e => {
                let file = e.currentTarget.getAttribute('data-src');
                this.queue.push(file);
            });
        });

        setInterval(() => {
            document.querySelector('.debug').innerHTML = JSON.stringify(this.queue);
        }, 50);

        setInterval(() => {
            if (this.queue.length > 0) {
                if (this.playing === false) {
                    this.playing = true;
                    // <dotlottie-player class="player" loop autoplay></dotlottie-player>
                    let $player = document.createElement('dotlottie-player');
                    $player.setAttribute('class', 'player');
                    $player.setAttribute('loop', '');
                    $player.setAttribute('autoplay', '');
                    $player.setAttribute('speed', '5');
                    document.querySelector('.player-container').appendChild($player);

                    $player.addEventListener('ready', () => {
                        //console.log('ready');
                        $player.closest('.player-container').classList.add('player-container--playing');
                        // remove other players(!)
                        if ($player.closest('.player-container').querySelectorAll('dotlottie-player').length > 1) {
                            $player
                                .closest('.player-container')
                                .querySelectorAll('dotlottie-player')
                                .forEach($el => {
                                    if ($el !== $player) {
                                        $el.remove();
                                    }
                                });
                        }
                    });

                    $player.addEventListener('loopComplete', () => {
                        //console.log('loopComplete');
                        $player.pause();
                        this.playing = false;
                        $player.closest('.player-container').classList.remove('player-container--playing');
                    });

                    // this timeout is needed, otherwise the eventlisteners won't work
                    let last = this.queue.shift();
                    setTimeout(() => {
                        $player.load('./_lottie/' + last);
                    }, 100);
                }
            }
        }, 250);
    }
}
